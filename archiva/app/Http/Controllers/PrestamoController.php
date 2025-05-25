<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use App\Models\User;
use Illuminate\Http\Request; // Asegúrate de que Request esté importado si usas filtros
use Carbon\Carbon;

class PrestamoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) // Añadido Request para los filtros
    {
        $query = Prestamo::with(['solicitante', 'receptor'])->latest();

        // Aplicar filtros (si se envían desde el formulario del index)
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

        $prestamos = $query->paginate(10)->appends($request->query()); // appends para mantener filtros en paginación

        // Datos para los select de filtros en la vista index
        // Es buena práctica obtener estos datos aquí para no repetir la lógica en la vista si no es necesario
        $usersForFilter = User::orderBy('name')->pluck('name', 'id');
        $estadosPrestamo = [
            'prestado' => 'Prestado',
            'devuelto' => 'Devuelto',
            'vencido' => 'Vencido',
        ];

        // Asegúrate de que la vista 'prestamos.index' exista en resources/views/prestamos/index.blade.php
        return view('./prestamos.index', compact('prestamos', 'usersForFilter', 'estadosPrestamo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::orderBy('name')->pluck('name', 'id');
        // Asegúrate de que la vista 'prestamos.create' exista en resources/views/prestamos/create.blade.php
        return view('prestamos.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id_solicitante' => 'required|exists:users,id',
            'user_id_receptor' => 'nullable|exists:users,id|different:user_id_solicitante',
            'fecha_prestamo' => 'required|date', // Si la BD tiene default, y este campo no se envía, la BD lo tomará.
                                             // Pero con 'required' aquí, siempre debe enviarse desde el form.
            'fecha_vencimiento' => 'nullable|date|after_or_equal:fecha_prestamo',
            // 'fecha_devolucion' no se valida aquí, se maneja en update o si el estado cambia.
            'estado' => 'required|in:prestado,devuelto,vencido',
            'firma_solicitante' => 'nullable|string|max:65535',
            'firma_receptor' => 'nullable|string|max:65535',
            'observaciones' => 'nullable|string|max:65535',
            'is_active' => 'sometimes|boolean', // 'sometimes' significa que solo se valida si está presente
        ]);

        $data = $validatedData;
        // El 'is_active' se maneja así porque un checkbox no enviado no manda valor.
        // Si se envía (marcado), $request->has('is_active') será true.
        // El 'boolean' en la validación se encargará de convertir 'on' o '1' a true/false para la BD si el campo es booleano.
        // Alternativamente, si el campo es tinyint(1) en la BD:
        $data['is_active'] = $request->has('is_active') ? 1 : 0;


        // La lógica de default para fecha_prestamo:
        // Si tu tabla 'prestamos' tiene 'DEFAULT current_timestamp()' para 'fecha_prestamo',
        // y el campo 'fecha_prestamo' es 'required' en el formulario HTML y en la validación de Laravel,
        // entonces este bloque de código es redundante porque el campo siempre tendrá un valor enviado.
        // Si el campo NO fuera 'required' y pudieras crearlo sin enviar 'fecha_prestamo',
        // la BD se encargaría del default.
        // Mantenemos el bloque por si acaso el 'required' se quita del formulario/validación en el futuro.
        // if (empty($data['fecha_prestamo'])) { // Esto es improbable si es 'required'
        //     $data['fecha_prestamo'] = Carbon::now();
        // }

        Prestamo::create($data);

        return redirect()->route('prestamos.index')->with('success', 'Préstamo creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Prestamo  $prestamo
     * @return \Illuminate\Http\Response
     */
    public function show(Prestamo $prestamo)
    {
        $prestamo->load(['solicitante', 'receptor']);
        // Asegúrate de que la vista 'prestamos.show' exista en resources/views/prestamos/show.blade.php
        return view('prestamos.show', compact('prestamo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Prestamo  $prestamo
     * @return \Illuminate\Http\Response
     */
    public function edit(Prestamo $prestamo)
    {
        $users = User::orderBy('name')->pluck('name', 'id');
        // Asegúrate de que la vista 'prestamos.edit' exista en resources/views/prestamos/edit.blade.php
        return view('prestamos.edit', compact('prestamo', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Prestamo  $prestamo
     * @return \Illuminate\Http\Response
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
        $data['is_active'] = $request->has('is_active') ? 1 : 0; // Para tinyint(1)

        // Si el estado cambia a 'devuelto' y no hay fecha de devolución, la ponemos ahora
        // y el campo fecha_devolucion no fue enviado con un valor.
        if ($data['estado'] === 'devuelto' && empty($data['fecha_devolucion']) && empty($prestamo->fecha_devolucion)) {
            $data['fecha_devolucion'] = Carbon::now();
        }
        // Si se desmarca 'devuelto' (cambia a otro estado) y antes estaba 'devuelto', limpiar fecha de devolución
        // O si el estado es devuelto pero se envía una fecha de devolución vacía, se toma esa.
        // Esta lógica permite al usuario borrar la fecha de devolución si lo desea, incluso si el estado es 'devuelto'.
        if ($data['estado'] !== 'devuelto' && $prestamo->estado === 'devuelto') {
             $data['fecha_devolucion'] = null;
        }
        // Si el estado sigue siendo 'devuelto' pero se envía fecha_devolucion vacía, se respeta
        // y no se auto-completa a Carbon::now() si ya tenía un valor previo.
        // La validación 'nullable' en fecha_devolucion permite esto.

        $prestamo->update($data);

        return redirect()->route('prestamos.index')->with('success', 'Préstamo actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Prestamo  $prestamo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prestamo $prestamo)
    {
        $prestamo->delete(); // Soft delete
        return redirect()->route('prestamos.index')->with('success', 'Préstamo eliminado exitosamente.');
    }
}