<x-admin-layout>
    <x-slot name="title">Editar Dependencia: {{ $dependencia->nombre }}</x-slot>

    <div class="container-fluid">
        <h1>Editar Dependencia</h1>

        <form method="POST" action="{{ route('admin.dependencias.update', $dependencia) }}">
            @csrf
            @method('PUT')

            @include('inventarios.dependencias._form')


            <button class="btn btn-success">Actualizar</button>
            <a href="{{ route('admin.dependencias.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</x-admin-layout>
