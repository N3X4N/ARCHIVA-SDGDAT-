<x-admin-layout>
    <x-slot name="title">Editar Ubicación: {{ $ubicacion->estante }}/{{ $ubicacion->bandeja }}</x-slot>
    <div class="container-fluid">
        <h1>Editar Ubicación</h1>
        <form method="POST" action="{{ route('inventarios.ubicaciones.update', ['ubicacion' => $ubicacion->id]) }}">
            @csrf
            @method('PUT')
            @include('inventarios.ubicaciones._form')
            <button class="btn btn-success">Actualizar</button>
            <a href="{{ route('inventarios.ubicaciones.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>

    </div>
</x-admin-layout>
