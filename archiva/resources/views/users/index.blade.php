<!-- resources/views/admin/users/index.blade.php -->
<x-admin-layout>
    <x-slot name="title">Gestión de Usuarios</x-slot>

    <div class="container-fluid">
        <h1 class="mb-4">Lista de Usuarios</h1>

        <a href="{{ route('admin.users.create') }}" class="btn btn-success mb-3">
            Nuevo Usuario
        </a>

        <!-- Formulario de filtros -->
        <form method="GET" action="{{ route('admin.users.index') }}">
            <div class="row">
                <!-- Filtro Nombre -->
                <div class="col-md-3">
                    <label for="name" class="form-label">Buscar por nombre</label>
                    <input type="text" name="name" class="form-control" value="{{ request('name') }}"
                        placeholder="Buscar por nombre">
                </div>

                <!-- Filtro Correo Electrónico -->
                <div class="col-md-3">
                    <label for="email" class="form-label">Buscar por correo</label>
                    <input type="email" name="email" class="form-control" value="{{ request('email') }}"
                        placeholder="Buscar por correo electrónico">
                </div>

                <!-- Filtro Rol -->
                <div class="col-md-3">
                    <label for="role_id" class="form-label">Rol</label>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle w-100" type="button" id="dropdownRole"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ request('role_id') ? $roles[request('role_id')] : 'Selecciona Rol' }}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownRole">
                            @foreach ($roles as $id => $label)
                                <a class="dropdown-item" href="{{ route('admin.users.index', ['role_id' => $id]) }}">
                                    {{ $label }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Filtro Estado -->
                <div class="col-md-3">
                    <label for="is_active" class="form-label">Estado</label>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle w-100" type="button" id="dropdownStatus"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ request('is_active') == '1' ? 'Activo' : (request('is_active') == '0' ? 'Inactivo' : 'Selecciona Estado') }}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownStatus">
                            <a class="dropdown-item"
                                href="{{ route('admin.users.index', ['is_active' => '1']) }}">Activo</a>
                            <a class="dropdown-item"
                                href="{{ route('admin.users.index', ['is_active' => '0']) }}">Inactivo</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botón para aplicar filtros -->
            <div class="row mt-3">
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                </div>
                <!-- Botón para limpiar filtros -->
                <div class="col-md-2">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary w-100">Limpiar
                        filtros</a>
                </div>
            </div>
        </form>

        <br>

        <!-- Paginación -->
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <span>Mostrando {{ $users->firstItem() }} a {{ $users->lastItem() }} de
                    {{ $users->total() }} resultados</span>
            </div>
            <div>
                {{ $users->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>



    <!-- Tabla -->
    <div class="table-responsive">
        <table class="table table-bordered w-100">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th style="width: 170px">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ optional($user->role)->nombre_rol ?? '—' }}</td>
                        <td>
                            <i class="fa {{ $user->is_active ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }}"></i>
                            {{ $user->is_active ? 'Activo' : 'Inactivo' }}
                        </td>

                        <td class="d-flex gap-1">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-primary">
                                <i class="fa-solid fa-pen"></i>
                                Editar
                            </a>

                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                onsubmit="return confirm('¿Eliminar usuario?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="fa-solid fa-trash"></i>
                                    Borrar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No hay usuarios registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>
