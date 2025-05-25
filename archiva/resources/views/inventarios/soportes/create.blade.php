{{-- resources/views/inventarios/soportes/create.blade.php --}}
<x-admin-layout>
    <x-slot name="title">Nuevo Soporte</x-slot>
    <div class="container-fluid">
        <h1>Crear Soporte</h1>
        <form method="POST" action="{{ route('inventarios.soportes.store') }}">
            @csrf
            @include('inventarios.soportes._form')
            <button class="btn btn-success">Guardar</button>
            <a href="{{ route('inventarios.soportes.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</x-admin-layout>
