<x-admin-layout>
    <x-slot name="title">Nueva Dependencia</x-slot>

    <div class="container-fluid">
        <h1>Crear Dependencia</h1>

        <form method="POST" action="{{ route('admin.dependencias.store') }}">
            @csrf

            @include('inventarios.dependencias._form')


            <button class="btn btn-success">Guardar</button>
            <a href="{{ route('admin.dependencias.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</x-admin-layout>
