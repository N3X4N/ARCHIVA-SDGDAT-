<x-admin-layout>
    <x-slot name="title">Nueva Ubicación</x-slot>
    <div class="container-fluid">
        <h1>Crear Ubicación</h1>
        <form method="POST" action="{{ route('inventarios.ubicaciones.store') }}">
            @csrf
            @include('inventarios.ubicaciones._form')
            <button class="btn btn-success">Guardar</button>
            <a href="{{ route('inventarios.ubicaciones.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</x-admin-layout>
