<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PrestamoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Prestamo::with(['solicitante', 'receptor'])->latest();

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

        $usersForFilter = User::orderBy('name')->pluck('name', 'id');
        $estadosPrestamo = [
            'prestado' => 'Prestado',
            'devuelto' => 'Devuelto',
            'vencido' => 'Vencido',
        ];

        return view('prestamos.index', compact('prestamos', 'usersForFilter', 'estadosPrestamo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::orderBy('name')->pluck('name', 'id');
        return view('prestamos.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id_solicitante' => 'required|exists:users,id',
            'user_id_receptor' => 'nullable|exists:users,id|different:user_id_solicitante',
            'fecha_prestamo' => 'required|date',
            'fecha_vencimiento' => 'nullable|date|after_or_equal:fecha_prestamo',
            'estado' => 'required|in:prestado,devuelto,vencido',
            'firma_solicitante' => 'nullable|string|max:65535',
            'firma_receptor' => 'nullable|string|max:65535',
            'observaciones' => 'nullable|string|max:65535',
            'is_active' => 'sometimes|boolean',
        ]);

        $data = $validatedData;
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        Prestamo::create($data);

        return redirect()
            ->route('prestamos.index')
            ->with('alertType', 'success')
            ->with('alertMessage', 'Préstamo creado exitosamente.');
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
        $users = User::orderBy('name')->pluck('name', 'id');
        return view('prestamos.edit', compact('prestamo', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prestamo $prestamo)
    {
        $validatedData = $request->validate([
            'user_id_solicitante' => 'required|exists:users,id',
            'user_id_receptor' => 'nullable|exists:users,id|different:user_id_solicitante',
            'fecha_prestamo' => 'required|date',
            'fecha_vencimiento' => 'nullable|date|after_or_equal:fecha_prestamo',
            'fecha_devolucion' => 'nullable|date|after_or_equal:fecha_prestamo',
            'estado' => 'required|in:prestado,devuelto,vencido',
            'firma_solicitante' => 'nullable|string|max:65535',
            'firma_receptor' => 'nullable|string|max:65535',
            'observaciones' => 'nullable|string|max:65535',
            'is_active' => 'sometimes|boolean',
        ]);

        $data = $validatedData;
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        if ($data['estado'] === 'devuelto' && empty($data['fecha_devolucion']) && empty($prestamo->fecha_devolucion)) {
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
}
