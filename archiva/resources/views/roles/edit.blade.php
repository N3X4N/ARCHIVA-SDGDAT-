<x-admin-layout>
    <x-slot name="title">Editar Rol - {{ $role->nombre_rol }}</x-slot>

    <div class="container">
        <h1>Editar Rol: {{ $role->nombre_rol }}</h1>

        <form action="{{ route('admin.roles.update', $role) }}" method="POST">
            @csrf
            @method('PUT')

            @include('roles._form', ['role' => $role])

            <button class="btn btn-success">Actualizar</button>
            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</x-admin-layout>

