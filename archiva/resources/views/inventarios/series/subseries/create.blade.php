<x-admin-layout>
    <x-slot name="title">Nueva Subserie de {{ $series->nombre }}</x-slot>
    <div class="container-fluid">
        <h1 class="mb-4">Crear Subserie para “{{ $series->nombre }}”</h1>

        <form method="POST" action="{{ route('inventarios.series.subseries.store', ['series' => $series->id]) }}">
            @csrf

            {{-- Campos de la subserie (prefijo + sufijo, nombre, estado) --}}
            @include('inventarios.series.subseries._form')

            <div class="mt-4">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-save me-1"></i> Guardar
                </button>
                <a href="{{ route('inventarios.series.subseries.index', ['series' => $series->id]) }}"
                    class="btn btn-secondary">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</x-admin-layout>
