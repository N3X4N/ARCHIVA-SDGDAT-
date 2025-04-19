<!-- resources/views/admin/users/edit.blade.php -->
<x-admin-layout>
    <x-slot name="title">Editar Usuario</x-slot>

    <div class="container">
      <h1>Editar Usuario #{{ $user->id }}</h1>

      <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf @method('PUT')

        @include('users._form', compact('user','roles'))

        <button class="btn btn-success">Actualizar</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancelar</a>
      </form>
    </div>
  </x-admin-layout>
