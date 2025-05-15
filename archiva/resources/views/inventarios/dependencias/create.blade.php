<x-admin-layout>
    <x-slot name="title">Nueva Serie Documental</x-slot>
    <div class="container-fluid">
        <h1>Crear Serie Documental</h1>
        <form method="POST" action="{{ route('series.store') }}">
            @csrf
            @include('series._form')
            <button class="btn btn-success">Guardar</button>
            <a href="{{ route('series.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</x-admin-layout>
