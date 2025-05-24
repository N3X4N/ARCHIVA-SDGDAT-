{{-- resources/views/inventarios/tipos_documentales/create.blade.php --}}
<x-admin-layout>
    <x-slot name="title">Nuevo Tipo Documental</x-slot>

    <div class="container-fluid">
        <h1 class="mb-4">Crear Tipo Documental</h1>

        <form method="POST" action="{{ route('inventarios.tipos-documentales.store') }}">
            @csrf
            @include('inventarios.tipos_documentales._form')
            <button class="btn btn-primary">Guardar</button>
            <a href="{{ route('inventarios.tipos-documentales.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</x-admin-layout>
