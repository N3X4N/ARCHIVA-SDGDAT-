<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dependencia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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
            'nombre'    => [
                'required',
                'string',
                'unique:dependencias,nombre'
            ],
            'sigla'     => [
                'required',
                'alpha',
                'max:3',
                'unique:dependencias,sigla'
            ],
            'codigo'    => [
                'required',
                'regex:/^\d+$/',
                'unique:dependencias,codigo'
            ],
            'is_active' => ['required', 'boolean'],
        ], [
            'nombre.unique' => 'Ese nombre ya está en uso.',
            'sigla.unique'  => 'Esa sigla ya está en uso.',
            'codigo.unique' => 'Ese código ya está en uso.',
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
        $data = $request->validate([
            'nombre'    => [
                'required',
                'string',
                'max:255',
                Rule::unique('dependencias', 'nombre')
                    ->ignore($dependencia->id)
            ],
            'sigla'     => [
                'required',
                'alpha',
                'max:3',
                Rule::unique('dependencias', 'sigla')
                    ->ignore($dependencia->id)
            ],
            'codigo'    => [
                'required',
                'regex:/^\d+$/',
                Rule::unique('dependencias', 'codigo')
                    ->ignore($dependencia->id)
            ],
            'is_active' => ['required', 'boolean'],
        ], [
            'nombre.unique' => 'Ese nombre ya está en uso por otra dependencia.',
            'sigla.unique'  => 'Esa sigla ya está en uso por otra dependencia.',
            'codigo.unique' => 'Ese código ya está en uso por otra dependencia.',
        ]);

        $data['nombre'] = strtoupper($data['nombre']);
        $data['sigla']  = strtoupper($data['sigla']);

        $dependencia->update($data);

        return redirect()
            ->route('inventarios.dependencias.index')
            ->with('alertType', 'success')
            ->with('alertMessage', 'Dependencia actualizada correctamente.');
    }


    public function destroy(Dependencia $dependencia)
    {
        // OJO: solo bloquea si también quieres impedir borrar con usuarios ligados
        $tieneUsers = $dependencia->users()->exists();

        if ($tieneUsers) {
            return redirect()
                ->route('admin.dependencias.index')
                ->with('alertType', 'warning')
                ->with('alertMessage', 'No se puede eliminar esta dependencia porque está asociada a usuarios.');
        }

        // Si llega aquí, elimina normalmente
        $dependencia->delete();

        return redirect()
            ->route('admin.dependencias.index')
            ->with('alertType', 'success')
            ->with('alertMessage', 'Dependencia eliminada correctamente.');
    }
}
