<x-admin-layout>
    <x-slot name="title">Editar Serie: {{ $serie->nombre }}</x-slot>
    <div class="container-fluid">
        <h1>Editar Serie Documental</h1>
        <form method="POST" action="{{ route('series.update', $serie) }}">
            @csrf @method('PUT')
            @include('series._form')
            <button class="btn btn-success">Actualizar</button>
            <a href="{{ route('series.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</x-admin-layout>
