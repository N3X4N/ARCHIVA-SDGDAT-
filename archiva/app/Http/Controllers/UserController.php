<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        // Aquí puedes agregar la lógica para crear un nuevo usuario si lo requieres
    }

    public function show($id)
    {
        // Aquí puedes agregar la lógica para mostrar un usuario específico
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all(); // O, si solo necesitas los nombres, Role::pluck('name')
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validación básica (ajusta las reglas según tus necesidades)
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'roles'    => 'required|array'
        ]);

        $user->name  = $data['name'];
        $user->email = $data['email'];

        // Solo actualiza la contraseña si se proporcionó
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        // Actualiza los roles (usando Spatie)
        $user->syncRoles($data['roles']);

        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy($id)
    {
        // Aquí puedes agregar la lógica para eliminar lógicamente (o eliminar físicamente) el usuario
    }
}
