<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use App\Models\User;
use App\Models\DetallesTransferenciaDocumental;
use App\Models\DetallePrestamo;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PrestamoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Prestamo::with([
            'solicitante.perfil',
            'receptor.perfil',
            'detallesPrestamo.detalleTransferencia.serie',
            'detallesPrestamo.detalleTransferencia.subserie',
            'detallesPrestamo.detalleTransferencia.ubicacion',
        ])->latest();

        // filtros existentes…
        if ($request->filled('user_id_solicitante_filter')) {
            $query->where('user_id_solicitante', $request->user_id_solicitante_filter);
        }
        if ($request->filled('estado_filter')) {
            $query->where('estado', $request->estado_filter);
        }
        if ($request->filled('fecha_prestamo_inicio')) {
            $query->whereDate('fecha_prestamo', '>=', $request->fecha_prestamo_inicio);
        }
        if ($request->filled('fecha_prestamo_fin')) {
            $query->whereDate('fecha_prestamo', '<=', $request->fecha_prestamo_fin);
        }

        $prestamos = $query->paginate(10)->appends($request->query());

        $usersForFilter = User::with('perfil')
            ->get()
            ->sortBy(fn($u) => $u->full_name)
            ->pluck('full_name', 'id');

        $estadosPrestamo = [
            'prestado' => 'Prestado',
            'devuelto' => 'Devuelto',
            'vencido'  => 'Vencido',
        ];

        return view('inventarios.prestamos.index', compact(
            'prestamos',
            'usersForFilter',
            'estadosPrestamo'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $users    = User::with('perfil')->get()->sortBy(fn($u) => $u->full_name)->pluck('full_name', 'id');
        $selected = $request->query('detalles', []);        // IDs venidos de seleccionar()

        // mantenemos la lista completa para que vuelva a mostrar en el form
        $detallesTransferencia = DetallesTransferenciaDocumental::with(['serie', 'subserie', 'ubicacion'])
            ->where('estado_flujo', 'activo')
            ->get();

        return view('inventarios.prestamos.create', compact('users', 'detallesTransferencia', 'selected'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id_solicitante'    => 'required|exists:users,id',
            'user_id_receptor'       => 'nullable|exists:users,id|different:user_id_solicitante',
            'fecha_prestamo'         => 'required|date',
            'fecha_vencimiento'      => 'nullable|date|after_or_equal:fecha_prestamo',
            'detalles'               => 'required|array|min:1',
            'detalles.*'             => 'exists:detalles_transferencias_documentales,id',
            'firma_solicitante'      => 'nullable|string|max:65535',
            'firma_receptor'         => 'nullable|string|max:65535',
            'observaciones'          => 'nullable|string|max:65535',
            'is_active'              => 'sometimes|boolean',
        ]);

        // 1) Crear el préstamo con todos los campos
        $prestamo = Prestamo::create([
            'user_id_solicitante'  => $validated['user_id_solicitante'],
            'user_id_receptor'     => $validated['user_id_receptor'] ?? null,
            'fecha_prestamo'       => $validated['fecha_prestamo'],
            'fecha_vencimiento'    => $validated['fecha_vencimiento'] ?? null,
            'estado'               => 'prestado',
            'firma_solicitante'    => $validated['firma_solicitante'] ?? null,
            'firma_receptor'       => $validated['firma_receptor'] ?? null,
            'observaciones'        => $validated['observaciones'] ?? null,
            'is_active'            => $request->has('is_active'),
        ]);

        // 2) Asociar cada detalle y marcarlo como prestado
        foreach ($validated['detalles'] as $detalleId) {
            $d = DetallesTransferenciaDocumental::findOrFail($detalleId);

            // Registra en detalles_prestamo
            DetallePrestamo::create([
                'prestamo_id'                 => $prestamo->id,
                'transferencia_documental_id' => $d->id,
                'ubicacion_id'                => $d->ubicacion_id,
                'cantidad'                    => 1,
                'is_active'                   => true,
            ]);

            // Marca el ítem en el catálogo como prestado
            $d->update(['estado_flujo' => 'prestado']);
        }

        return redirect()
            ->route('prestamos.index')
            ->with('alertType', 'success')
            ->with('alertMessage', 'Préstamo creado y detalles marcados como prestados.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Prestamo $prestamo)
    {
        $prestamo->load(['solicitante', 'receptor']);
        return view('prestamos.show', compact('prestamo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prestamo $prestamo)
    {
        $users = User::with('perfil')
            ->get()
            ->sortBy(fn($u) => $u->full_name)
            ->pluck('full_name', 'id');

        $usersFull = User::with('perfil')->get();

        $detallesTransferencia = DetallesTransferenciaDocumental::with(['serie', 'subserie', 'ubicacion'])
            ->where('estado_flujo', 'activo')
            ->get();

        return view('prestamos.edit', compact(
            'prestamo',
            'users',
            'usersFull',
            'detallesTransferencia'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prestamo $prestamo)
    {
        $validatedData = $request->validate([
            'user_id_solicitante'  => 'required|exists:users,id',
            'user_id_receptor'     => 'nullable|exists:users,id|different:user_id_solicitante',
            'fecha_prestamo'       => 'required|date',
            'fecha_vencimiento'    => 'nullable|date|after_or_equal:fecha_prestamo',
            'fecha_devolucion'     => 'nullable|date|after_or_equal:fecha_prestamo',
            'estado'               => 'required|in:prestado,devuelto,vencido',
            'firma_solicitante'    => 'nullable|string|max:65535',
            'firma_receptor'       => 'nullable|string|max:65535',
            'observaciones'        => 'nullable|string|max:65535',
            'is_active'            => 'sometimes|boolean',
        ]);

        $data = $validatedData;
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        if (
            $data['estado'] === 'devuelto'
            && empty($data['fecha_devolucion'])
            && empty($prestamo->fecha_devolucion)
        ) {
            $data['fecha_devolucion'] = Carbon::now();
        }

        if ($data['estado'] !== 'devuelto' && $prestamo->estado === 'devuelto') {
            $data['fecha_devolucion'] = null;
        }

        $prestamo->update($data);

        return redirect()
            ->route('prestamos.index')
            ->with('alertType', 'success')
            ->with('alertMessage', 'Préstamo actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prestamo $prestamo)
    {
        $prestamo->delete();

        return redirect()
            ->route('prestamos.index')
            ->with('alertType', 'success')
            ->with('alertMessage', 'Préstamo eliminado exitosamente.');
    }


    public function seleccionar(Request $request)
    {
        // traemos ítems activos con paginación y relaciones
        $detalles = DetallesTransferenciaDocumental::with(['serie', 'subserie', 'ubicacion'])
            ->where('estado_flujo', 'activo')
            ->paginate(20);

        return view('prestamos.seleccionar', compact('detalles'));
    }
}
