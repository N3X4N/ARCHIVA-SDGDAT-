{{-- resources/views/inventarios/tipos_documentales/edit.blade.php --}}
<x-admin-layout>
    <x-slot name="title">Editar Tipo Documental</x-slot>

    <div class="container-fluid">
        <h1 class="mb-4">Editar «{{ $tipo_documental->nombre }}»</h1>

        <form method="POST" action="{{ route('inventarios.tipos-documentales.update', $tipo_documental) }}">
            @csrf
            @method('PUT')

            @include('inventarios.tipos_documentales._form')

            <button class="btn btn-primary">Actualizar</button>
            <a href="{{ route('inventarios.tipos-documentales.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</x-admin-layout>
