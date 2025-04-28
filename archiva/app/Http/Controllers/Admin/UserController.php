<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Mostrar lista de usuarios
    public function index(Request $request)
{
    $query = User::with('role');

    // Filtro por nombre
    if ($request->filled('name')) {
        $query->where('name', 'like', '%' . $request->name . '%');
    }

    // Filtro por email
    if ($request->filled('email')) {
        $query->where('email', 'like', '%' . $request->email . '%');
    }

    // Filtro por rol
    if ($request->filled('role')) {      // role = slug (admin/user) o ID; ajusta
        $query->whereHas('role', function ($q) use ($request) {
            $q->where('nombre_rol', $request->role);
        });
    }

    // Filtro por estado
    if ($request->has('is_active') && $request->is_active !== '') {
        $query->where('is_active', $request->is_active);
    }

    $users = $query->paginate(15)->appends($request->query());   // mantiene filtros en links
    return view('users.index', compact('users'));
}

    // Formulario para crear usuario
    public function create()
    {
        // Solo roles activos
        $roles = Role::where('is_active', true)
            ->pluck('nombre_rol', 'id');
        return view('users.create', compact('roles'));
    }

    // Almacenar nuevo usuario
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:120',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role_id'  => 'required|exists:roles,id',
            'is_active' => 'sometimes|boolean',
        ]);

        $data['password']  = Hash::make($data['password']);
        $data['is_active'] = $request->has('is_active');

        User::create($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    // Mostrar datos de un usuario
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    // Formulario para editar usuario
    public function edit(User $user)
    {
        $roles = Role::where('is_active', true)
            ->pluck('nombre_rol', 'id');

        // Pasa tanto el modelo $user como los $roles a la vista
        return view('users.edit', compact('user', 'roles'));
    }

    // Actualizar usuario
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:120',
            'email'    => "required|email|unique:users,email,{$user->id}",
            'password' => 'nullable|string|min:8|confirmed',
            'role_id'  => 'required|exists:roles,id',
            'is_active' => 'sometimes|boolean',
        ]);

        if ($data['password'] ?? null) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $data['is_active'] = $request->has('is_active');

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    // Eliminar usuario (soft delete si está habilitado)
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario eliminado.');
    }
}
