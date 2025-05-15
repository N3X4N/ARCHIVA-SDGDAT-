<!-- resources/views/admin/users/edit.blade.php -->
<x-admin-layout>
    <x-slot name="title">Editar Usuario - {{ $user->name }}</x-slot>

    <div class="container">
        <!-- Título con el nombre del usuario -->
        <h1>Editar Usuario: {{ $user->name }}</h1>

        <!-- Formulario de actualización de usuario -->
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Inclusión del formulario de usuario -->
            @include('users._form', compact('user', 'roles'))

            <!-- Botones de acción -->

            <button class="btn btn-success">Actualizar</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancelar</a>

        </form>
    </div>
</x-admin-layout>
