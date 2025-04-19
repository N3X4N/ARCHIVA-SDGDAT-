<!-- resources/views/home.blade.php -->
<x-admin-layout>
    <x-slot name="title">
        Dashboard - {{ auth()->user()->name }}
    </x-slot>

    <h1>Bienvenido, {{ auth()->user()->name }}</h1>
    <p>Aquí va el contenido principal de tu aplicación, dinámico para el usuario autenticado.</p>

    <h2 class="mt-5">Listado de Usuarios</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Roles</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        {{ implode(', ', $user->getRoleNames()->toArray()) }}
                    </td>
                    <td>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <!-- Aquí podrías agregar otras acciones, como eliminar lógicamente -->
                    </td>
                </tr>
            @endforeach --}}
        </tbody>
    </table>
</x-admin-layout>
