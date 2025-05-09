<x-admin-layout>
    <x-slot name="title">Crear Dependencia</x-slot>

    <div class="container">
        <h1 class="mb-4">Crear Dependencia</h1>
        <form action="{{ route('inventarios.dependencias.store') }}" method="POST" autocomplete="off">
            @csrf
            @include('inventarios.dependencias._form', ['dependencia' => new \App\Models\Dependencia])
            <button class="btn btn-success">Guardar</button>
            <a href="{{ route('inventarios.dependencias.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</x-admin-layout>
