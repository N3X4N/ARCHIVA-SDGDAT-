<x-admin-layout>
    <x-slot name="title">Editar Dependencia - {{ $dependencia->nombre }}</x-slot>

    <div class="container">
      <h1>Editar Dependencia: {{ $dependencia->nombre }}</h1>

      <form action="{{ route('inventarios.dependencias.update', $dependencia) }}" method="POST">
        @csrf
        @method('PUT')
        @include('inventarios.dependencias._form')
        <button class="btn btn-success">Actualizar</button>
        <a href="{{ route('inventarios.dependencias.index') }}" class="btn btn-secondary">Cancelar</a>
      </form>
    </div>
  </x-admin-layout>
