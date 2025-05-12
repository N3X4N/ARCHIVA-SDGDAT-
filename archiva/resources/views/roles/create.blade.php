<x-admin-layout>
    <x-slot name="title">Crear Rol</x-slot>

    <div class="container">
        <h1 class="mb-4">Crear Rol</h1>

        <form action="{{ route('admin.roles.store') }}" method="POST" autocomplete="off">
            @csrf

            @include('roles._form')

            <button class="btn btn-success">Guardar</button>
            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</x-admin-layout>

