<!-- resources/views/admin/users/index.blade.php -->
<x-admin-layout>
    <x-slot name="title">Gestión de Usuarios</x-slot>

    <div class="container-fluid">
        <h1 class="mb-4">Lista de Usuarios</h1>

        <a href="{{ route('admin.users.create') }}" class="btn btn-success mb-3">
            Nuevo Usuario
        </a>

         <!-- Formulario de filtros -->
         <form method="GET" action="{{ route('admin.users.index') }}" class="mb-4">
            <div class="row">
                <!-- Filtro por nombre -->
                <div class="col-md-3">
                    <label for="name">Nombre</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Buscar por nombre" value="{{ request()->get('name') }}">
                </div>

                <!-- Filtro por correo electrónico -->
                <div class="col-md-3">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Buscar por correo" value="{{ request()->get('email') }}">
                </div>

                <!-- Filtro por rol -->
                <div class="col-md-3">
                    <label for="role">Rol</label>
                    <select name="role" id="role" class="form-control">
                        <option value="">Seleccionar Rol</option>
                        <option value="admin" {{ request()->get('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="user" {{ request()->get('role') == 'user' ? 'selected' : '' }}>Usuario</option>
                    </select>
                </div>

                <!-- Filtro por estado -->
                <div class="col-md-2">
                    <label for="is_active">Estado</label>
                    <select name="is_active" id="is_active" class="form-control">
                        <option value="">Todos</option>
                        <option value="1" {{ request()->get('is_active') == '1' ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ request()->get('is_active') == '0' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>

                <!-- Botón de filtro -->
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                </div>
            </div>
        </form>



        <div class="table-responsive">
            <table class="table table-bordered w-100">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Activo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            {{ optional($user->role)->nombre_rol ?: '—' }}
                        </td>
                        <td class="d-flex gap-1">
                            <!-- Botón Editar con ícono -->
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-primary" title="Editar">
                                <i class="fa-solid fa-pen"></i> Editar
                            </a>

                            <!-- Botón Borrar con ícono -->
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('¿Eliminar usuario?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" title="Borrar">
                                    <i class="fa-solid fa-trash"></i> Borrar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        {{ $users->links() }}
        <!-- Paginación -->
        <nav aria-label="Paginación de Transferencias">
            <ul class="pagination justify-content-end">
                <li class="page-item disabled">
                    <span class="page-link">Anterior</span>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item active">
                    <span class="page-link">
                        2
                        <span class="sr-only">(actual)</span>
                    </span>
                </li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Siguiente</a>
                </li>
            </ul>
        </nav>
    </div>
</x-admin-layout>
