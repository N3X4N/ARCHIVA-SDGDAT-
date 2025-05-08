<x-admin-layout>
    <x-slot name="title">Gestión de Usuarios</x-slot>

    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Lista de Usuarios</h1>
            <a href="{{ route('admin.users.create') }}" class="btn btn-success">
                <i class="fa fa-plus me-1"></i> Nuevo Usuario
            </a>
        </div>

        <!-- Formulario de filtros -->
        <form method="GET" action="{{ route('admin.users.index') }}">
            <div class="row g-3 align-items-end">
                <!-- Filtro Nombre -->
                <div class="col-md-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" name="name" class="form-control" value="{{ request('name') }}"
                        placeholder="Buscar por nombre">
                </div>

                <!-- Filtro Email -->
                <div class="col-md-3">
                    <label for="email" class="form-label">Correo</label>
                    <input type="email" name="email" class="form-control" value="{{ request('email') }}"
                        placeholder="Buscar por correo">
                </div>

                <div class="col-md-3">
                    <label for="is_active" class="form-label">Estado</label>
                    <select name="is_active" class="form-control">
                        <option value="">Seleccione...</option>
                        @foreach (['1' => 'Activo', '0' => 'Inactivo'] as $is_active => $estado)
                        <option value="{{ $is_active }}"
                            {{ request('is_active') == $is_active ? 'selected' : '' }}>
                            {{ $estado }}
                        </option>
                        @endforeach
                    </select>
                </div>



                <div class="col-md-3">
                    <label for="is_active" class="form-label">Estado</label>
                    <select name="is_active" class="form-control">
                        <option value="">Seleccione...</option>
                        <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>


            </div>

            <!-- Botones -->
            <div class="row mt-3">
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fa fa-filter me-1"></i> Filtrar
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary w-100">
                        Limpiar filtros
                    </a>
                </div>
            </div>
        </form>

        <!-- Paginación -->
        <div class="d-flex justify-content-between align-items-center mt-4 mb-2">
            <div>
                <small>
                    Mostrando {{ $users->firstItem() }} a {{ $users->lastItem() }} de {{ $users->total() }} resultados
                </small>
            </div>
            <div>
                {{ $users->links('pagination::bootstrap-4') }}
            </div>
        </div>

        <!-- Tabla -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th style="width: 180px;">Acciones</th>
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
                        <td class="d-flex justify-content-center gap-1">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-primary">
                                <i class="fa-solid fa-pen"></i> Editar
                            </a>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                onsubmit="return confirm('¿Eliminar usuario?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="fa-solid fa-trash"></i> Borrar
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
    </div>
</x-admin-layout>