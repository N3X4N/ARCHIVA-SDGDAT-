<?php

namespace App\Http\Controllers\Inventarios;

use App\Http\Controllers\Controller;
use App\Models\Soporte;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SoporteController extends Controller
{
    /**
     * index: lista paginada de soportes, con filtro opcional por nombre y estado.
     */
    public function index(Request $request)
    {
        $query = Soporte::query();

        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%'.trim($request->nombre).'%');
        }
        if ($request->filled('is_active')) {
            $query->where('is_active', (bool)$request->is_active);
        }

        $soportes = $query
            ->orderBy('nombre')
            ->paginate(15)
            ->appends($request->only('nombre', 'is_active'));

        return view('inventarios.soportes.index', compact('soportes'));
    }

    /**
     * create: muestra el formulario para crear un soporte.
     */
    public function create()
    {
        return view('inventarios.soportes.create');
    }

    /**
     * store: valida y crea un nuevo soporte (nombre único, desc opcional, is_active requerido).
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'      => ['required','string','max:60','unique:soportes,nombre'],
            'descripcion' => ['nullable','string'],
            'is_active'   => ['required','boolean'],
        ]);

        // Normalizar: mayúsculas y trim
        $data['nombre'] = strtoupper(trim($data['nombre']));

        Soporte::create($data);

        return redirect()
            ->route('inventarios.soportes.index')
            ->with('alertType','success')
            ->with('alertMessage','Soporte creado correctamente.');
    }

    /**
     * edit: muestra el formulario para editar un soporte existente.
     */
    public function edit(Soporte $soporte)
    {
        return view('inventarios.soportes.edit', compact('soporte'));
    }

    /**
     * update: valida y actualiza; mantiene unicidad de nombre ignorando el propio registro.
     */
    public function update(Request $request, Soporte $soporte)
    {
        $data = $request->validate([
            'nombre'      => [
                'required','string','max:60',
                Rule::unique('soportes','nombre')->ignore($soporte->id)
            ],
            'descripcion' => ['nullable','string'],
            'is_active'   => ['required','boolean'],
        ]);

        $data['nombre'] = strtoupper(trim($data['nombre']));
        $soporte->update($data);

        return redirect()
            ->route('inventarios.soportes.index')
            ->with('alertType','success')
            ->with('alertMessage','Soporte actualizado correctamente.');
    }

    /**
     * destroy: soft-delete si NO tiene detalles de transferencia asociados.
     */
    public function destroy(Soporte $soporte)
    {
        if ($soporte->detallesTransferencias()->exists()) {
            return redirect()
                ->route('inventarios.soportes.index')
                ->with('alertType','error')
                ->with('alertMessage','No se puede eliminar: tiene transferencias asociadas.');
        }

        $soporte->delete();

        return redirect()
            ->route('inventarios.soportes.index')
            ->with('alertType','success')
            ->with('alertMessage','Soporte eliminado correctamente.');
    }
}
