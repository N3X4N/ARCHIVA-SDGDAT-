<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dependencia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DependenciaController extends Controller
{
    public function index(Request $request)
    {
        $query = Dependencia::query();

        // Estado (opcional)
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        // Nombre: sólo si escribiste algo
        if ($request->filled('nombre')) {
            $buscado = Str::lower(trim($request->nombre));

            // Forzamos minúsculas en la columna y en el término de búsqueda
            $query->whereRaw('LOWER(nombre) LIKE ?', ["%{$buscado}%"]);
        }

        // Paginamos y mantenemos los filtros en la URL
        $dependencias = $query
            ->paginate(50)
            ->appends($request->only(['nombre', 'is_active']));

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
