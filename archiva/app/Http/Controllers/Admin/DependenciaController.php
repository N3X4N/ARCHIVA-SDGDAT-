<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dependencia;
use Illuminate\Http\Request;

class DependenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Dependencia::query();

        // Filtrar por estado (activo/inactivo)
        if ($request->has('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        // Filtrar por nombre
        if ($request->has('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        // Paginación
        $dependencias = $query->paginate(50);

        return view('inventarios.dependencias.index', compact('dependencias'));
    }

    public function create()
    {
        return view('inventarios.dependencias.create');  // Crear vista para formulario de dependencias
    }

    public function edit(Dependencia $dependencia)
    {
        return view('inventarios.dependencias.edit', compact('dependencia'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'    => ['required', 'string'],
            'sigla'     => ['required', 'alpha'],
            'codigo'    => ['required', 'regex:/^\d+$/'],
            'is_active' => ['required', 'boolean'],
        ]);

        // Asegurar que se guarde en mayúsculas
        $data['nombre'] = strtoupper($data['nombre']);
        $data['sigla']  = strtoupper($data['sigla']);

        Dependencia::create($data);

        return redirect()
            ->route('inventarios.dependencias.index')
            ->with('alertType', 'success')
            ->with('alertMessage', 'Dependencia creada correctamente.');
    }



    public function update(Request $request, Dependencia $dependencia)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'sigla' => 'nullable|string|max:50',
            'codigo' => 'nullable|string|max:50',
            'is_active' => 'required|boolean',
        ]);

        $dependencia->update($request->all());

        return redirect()->route('inventarios.dependencias.index')
            ->with('alertType', 'success')
            ->with('success', 'Dependencia actualizada correctamente.');
    }

    public function destroy(Dependencia $dependencia)
    {
        // 1) Comprobar si tiene transferencias relacionadas
        if ($dependencia->transferencias()->exists()) {
            return redirect()
                ->route('inventarios.dependencias.index')
                ->with('alertType', 'warning')
                ->with('alertMessage', 'No se puede eliminar esta dependencia porque tiene transferencias asociadas.');
        }

        // 2) Si no hay relaciones, eliminar con normalidad
        $dependencia->delete();

        return redirect()
            ->route('inventarios.dependencias.index')
            ->with('alertType', 'success')
            ->with('alertMessage', 'Dependencia eliminada correctamente.');
    }

}
