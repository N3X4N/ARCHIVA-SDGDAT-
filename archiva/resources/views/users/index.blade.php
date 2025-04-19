<!-- resources/views/admin/users/index.blade.php -->
<x-admin-layout>
    <x-slot name="title">Gestión de Usuarios</x-slot>

    <div class="container">
      <h1 class="mb-4">Lista de Usuarios</h1>

      <a href="{{ route('admin.users.create') }}" class="btn btn-success mb-3">
        Nuevo Usuario
      </a>

      <table class="table table-bordered">
        <thead>
          <tr>
            <th>ID</th><th>Nombre</th><th>Email</th><th>Rol</th><th>Activo</th><th>Acciones</th>
          </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
          <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
              {{-- En lugar de Spatie, mostramos el rol relacionado --}}
              {{ optional($user->role)->nombre_rol ?: '—' }}
            </td>
            <td>
              @if($user->is_active)
                <span class="badge bg-success">Sí</span>
              @else
                <span class="badge bg-secondary">No</span>
              @endif
            </td>
            <td class="d-flex gap-1">
              <a href="{{ route('admin.users.edit', $user) }}"
                 class="btn btn-sm btn-primary">Editar</a>
              <form action="{{ route('admin.users.destroy', $user) }}"
                    method="POST" onsubmit="return confirm('¿Eliminar usuario?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger">Borrar</button>
              </form>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>

      {{ $users->links() }}
    </div>
  </x-admin-layout>
