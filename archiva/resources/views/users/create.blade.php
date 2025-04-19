<!-- resources/views/admin/users/create.blade.php -->
<x-admin-layout>
    <x-slot name="title">Crear Usuario</x-slot>

    <div class="container">
      <h1>Crear Usuario</h1>

      <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf

        @include('users._form', [
          'user'  => new \App\Models\User,
          'roles' => $roles
        ])

        <button class="btn btn-success">Guardar</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancelar</a>
      </form>
    </div>
  </x-admin-layout>
