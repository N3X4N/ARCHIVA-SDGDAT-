<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class RoleController extends Controller
{
    public function index(Request $request)
    {
        // 1) Query base y filtros...
        $query = Role::query();
        if ($request->filled('is_active')) {
            $query->where('is_active', (bool) $request->is_active);
        }
        if ($request->filled('name')) {
            $term = Str::lower(trim($request->name));
            $query->whereRaw('LOWER(nombre_rol) LIKE ?', ["%{$term}%"]);
        }

        // 2) Paginación manteniendo filtros
        $roles = $query
            ->paginate(50)
            ->appends($request->only(['is_active', 'name']));
            

        // 4) Pasa todo a la vista
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

   
    public function store(Request $request)
    {
        $data = $request->validate([
        'nombre_rol'  => 'required|string|max:120|unique:roles,nombre_rol',
        'is_active'   => 'required|boolean',
        'description' => 'nullable|string|max:255',
    ], [
        'nombre_rol.required' => 'El campo nombre es obligatorio.',
        'nombre_rol.unique'   => 'Ya existe un rol con este nombre.',
        'nombre_rol.max'      => 'El nombre no debe superar los 120 caracteres.',
        'is_active.required'  => 'El estado es obligatorio.',
        'is_active.boolean'   => 'El estado debe ser verdadero o falso.',
        'description.max'     => 'La descripción no debe superar los 255 caracteres.',
    ]);

    Role::create($data);

    return redirect()
        ->route('admin.roles.index')
        ->with('alertType', 'success')
        ->with('alertMessage', 'Rol creado correctamente.');
    }

    public function show(Role $role)
    {
        //
    }

    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
         $data = $request->validate([
        'nombre_rol'  => 'required|string|max:120|unique:roles,nombre_rol,' . $role->id,
        'is_active'   => 'required|boolean',
        'description' => 'nullable|string|max:255',
    ], [
        'nombre_rol.required' => 'El campo nombre es obligatorio.',
        'nombre_rol.unique'   => 'Ya existe un rol con este nombre.',
        'nombre_rol.max'      => 'El nombre no debe superar los 120 caracteres.',
        'is_active.required'  => 'El estado es obligatorio.',
        'is_active.boolean'   => 'El estado debe ser verdadero o falso.',
        'description.max'     => 'La descripción no debe superar los 255 caracteres.',
    ]);

    $role->update($data);

    return redirect()
        ->route('admin.roles.index')
        ->with('alertType', 'success')
        ->with('alertMessage', 'Rol actualizado correctamente.');
    }
    public function destroy(Role $role)
    {
         // Verifica si el rol tiene usuarios asociados
    $hasUsers = $role->users()->exists();

    if ($hasUsers) {
        return redirect()
            ->route('admin.roles.index')
            ->with('alertType', 'warning')
            ->with('alertMessage', 'No se puede eliminar este rol porque está asociado a uno o más usuarios.');
    }

    $role->delete();

    return redirect()
        ->route('admin.roles.index')
        ->with('alertType', 'success')
        ->with('alertMessage', 'Rol eliminado correctamente.');
    }
}
