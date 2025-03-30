<!-- resources/views/users/index.blade.php -->
<x-admin-layout>
    <x-slot name="title">
        Gestión de Usuarios
    </x-slot>

    <div class="container">
        <h1 class="mb-4">Lista de Usuarios</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <!-- Si usas Spatie, puedes mostrar los roles asignados -->
                            @foreach ($user->getRoleNames() as $role)
                                <span class="badge badge-info">{{ $role }}</span>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary">Editar</a>
                            <!-- Puedes agregar botones adicionales según se requiera -->
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-admin-layout>
