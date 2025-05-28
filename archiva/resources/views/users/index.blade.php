<x-admin-layout>
    <x-slot name="title">Gestión de Usuarios</x-slot>

    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Lista de Usuarios</h1>
            <a href="{{ route('admin.users.create') }}" class="btn btn-success">
                <i class="fa fa-plus me-1"></i> Nuevo Usuario
            </a>
        </div>

        {{-- FILTROS --}}
        <form method="GET" action="{{ route('admin.users.index') }}">
            <div class="row g-3 align-items-end">
                {{-- Rol --}}
                <div class="col-md-3">
                    <label for="role_id" class="form-label">Rol</label>
                    <select name="role_id" id="role_id" class="form-select">
                        <option value="">Todos</option>
                        @foreach ($roles as $id => $rol)
                            <option value="{{ $id }}" {{ request('role_id') == $id ? 'selected' : '' }}>
                                {{ $rol }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="dependencia_id" class="form-label">Dependencia</label>
                    <select name="dependencia_id" id="dependencia_id" class="form-select">
                        <option value="">Todas</option>
                        @foreach ($dependencias as $id => $nombre)
                            <option value="{{ $id }}"
                                {{ request('dependencia_id') == $id ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Nombre --}}
                <div class="col-md-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" name="name" id="name" class="form-control"
                        placeholder="Buscar por nombre" value="{{ request('name') }}">
                </div>

                {{-- Email --}}
                <div class="col-md-3">
                    <label for="email" class="form-label">Correo</label>
                    <input type="email" name="email" id="email" class="form-control"
                        placeholder="Buscar por correo" value="{{ request('email') }}">
                </div>

                {{-- Estado --}}
                <div class="col-md-3">
                    <label for="is_active" class="form-label">Estado</label>
                    <select name="is_active" id="is_active" class="form-select">
                        <option value="">Todos</option>
                        <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>

                {{-- Botones --}}
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

        {{-- RESULTADOS / PAGINACIÓN --}}
        <div class="d-flex justify-content-between align-items-center mt-4 mb-2">
            <small>
                Mostrando {{ $users->firstItem() }} a {{ $users->lastItem() }} de {{ $users->total() }} resultados
            </small>
            <div>
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        </div>

        {{-- TABLA --}}
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Dependencia</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th style="width:180px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>
                                @if ($user->perfil)
                                    {{ $user->perfil->nombres }} {{ $user->perfil->apellidos }}
                                @else
                                    {{ $user->name }}
                                @endif
                            </td>
                            <td>{{ $user->dependencia->nombre ?? '—' }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ optional($user->role)->nombre_rol ?? '—' }}</td>
                            <td>
                                <i
                                    class="fa {{ $user->is_active ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }}"></i>
                                {{ $user->is_active ? 'Activo' : 'Inactivo' }}
                            </td>
                            <td class="d-flex justify-content-center gap-1">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-pen me-1"></i> Editar
                                </a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                    class="d-inline js-confirmable"
                                    data-confirm-message="¿Eliminar usuario «{{ $user->name }}»?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash"></i>
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
