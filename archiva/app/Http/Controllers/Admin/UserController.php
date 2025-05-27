<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Dependencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Lista usuarios con filtros por rol, estado, nombre y email.
     */
    public function index(Request $request)
    {
        // 0) Carga de dependencias para el filtro
        $dependencias = Dependencia::where('is_active', true)
            ->pluck('nombre', 'id');

        // 1) Pluck de roles
        $roles = Role::where('is_active', true)
            ->pluck('nombre_rol', 'id');

        // 2) Query base y filtros...
        $query = User::query();
        if ($request->filled('role_id')) {
            $query->where('role_id', $request->role_id);
        }
        if ($request->filled('dependencia_id')) {
            $query->where('dependencia_id', $request->dependencia_id);
        }
        if ($request->filled('is_active')) {
            $query->where('is_active', (bool) $request->is_active);
        }
        if ($request->filled('name')) {
            $term = Str::lower(trim($request->name));
            $query->whereRaw('LOWER(name) LIKE ?', ["%{$term}%"]);
        }
        if ($request->filled('email')) {
            $term = Str::lower(trim($request->email));
            $query->whereRaw('LOWER(email) LIKE ?', ["%{$term}%"]);
        }

        // 3) Paginación manteniendo filtros
        $users = $query
            ->paginate(50)
            ->appends($request->only(['role_id', 'dependencia_id', 'is_active', 'name', 'email']));

        // 4) Pasa todo a la vista
        return view('users.index', compact('users', 'roles', 'dependencias'));
    }

    /**
     * Muestra formulario de creación.
     */
    public function create()
    {
        $roles        = Role::where('is_active', true)->pluck('nombre_rol', 'id');
        $dependencias = Dependencia::where('is_active', true)->pluck('nombre', 'id');
        return view('users.create', compact('roles', 'dependencias'));
    }

    /**
     * Guarda nuevo usuario.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:120',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|string|min:8|confirmed',
            'role_id'   => 'required|exists:roles,id',
            'dependencia_id' => 'nullable|exists:dependencias,id',
            'is_active' => 'required|boolean',
        ]);

        $data['password']  = Hash::make($data['password']);
        // is_active llega como 0 o 1 gracias al hidden+checkbox en la vista
        User::create($data);

        return redirect()
            ->route('admin.users.index')
            ->with('alertType', 'success')
            ->with('alertMessage', 'Usuario creado correctamente.');
    }

    /**
     * Muestra formulario de edición.
     */
    public function edit(User $user)
    {
        // 1) Roles activos para el select
        $roles = Role::where('is_active', true)
            ->pluck('nombre_rol', 'id');

        // 2) Dependencias activas para el select
        $dependencias = Dependencia::where('is_active', true)
            ->pluck('nombre', 'id');

        // 3) Pasa todo a la vista
        return view('users.edit', compact('user', 'roles', 'dependencias'));
    }

    /**
     * Actualiza usuario existente.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'      => 'required|string|max:120',
            'email'     => "required|email|unique:users,email,{$user->id}",
            'password'  => 'nullable|string|min:8|confirmed',
            'role_id'   => 'required|exists:roles,id',
            'dependencia_id' => 'nullable|exists:dependencias,id',
            'is_active' => 'required|boolean',
        ]);

        $data = $request->all();

        // Si no cambió contraseña, la sacamos del array
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return redirect()
            ->route('admin.users.index')
            ->with('alertType', 'success')
            ->with('alertMessage', 'Usuario actualizado correctamente.');
    }

    /**
     * Elimina (soft delete) un usuario.
     */
    public function destroy(User $user)
    {
        $hasTransferencias = $user->transferencias()->exists();
        //$hasPrestamos      = $user->prestamos()->exists();
        $hasDependencia    = (bool) $user->dependencia; // si dependencia_id no es null

        if ($hasTransferencias || $hasDependencia) {
            return redirect()
                ->route('admin.users.index')
                ->with('alertType', 'warning')
                ->with('alertMessage', 'No se puede eliminar este usuario porque está asociado a datos en el sistema.');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('alertType', 'success')
            ->with('alertMessage', 'Usuario eliminado correctamente.');
    }
}
