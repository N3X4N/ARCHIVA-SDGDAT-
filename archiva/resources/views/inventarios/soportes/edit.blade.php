{{-- resources/views/inventarios/soportes/edit.blade.php --}}
<x-admin-layout>
    <x-slot name="title">Editar Soporte: {{ $soporte->nombre }}</x-slot>
    <div class="container-fluid">
        <h1>Editar Soporte</h1>
        <form method="POST" action="{{ route('inventarios.soportes.update', $soporte) }}">
            @csrf
            @method('PUT')
            @include('inventarios.soportes._form')
            <button class="btn btn-success">Actualizar</button>
            <a href="{{ route('inventarios.soportes.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</x-admin-layout>
