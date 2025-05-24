<!-- resources/views/inventarios/series/edit.blade.php -->
<x-admin-layout>
    <x-slot name="title">Editar Serie {{ $series->nombre }}</x-slot>
    <div class="container-fluid">
        <h1>Editar Serie Documental</h1>

        <form method="POST" action="{{ route('inventarios.series.update', $series) }}">
            @csrf
            @method('PUT')

            @include('inventarios.series._form')

            <button class="btn btn-success">Actualizar</button>
            <a href="{{ route('inventarios.series.index') }}" class="btn btn-secondary">
                Cancelar
            </a>
        </form>
    </div>
</x-admin-layout>
