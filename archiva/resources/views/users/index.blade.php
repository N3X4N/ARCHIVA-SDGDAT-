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
    <div class="row g-3">

        {{-- Nombre --}}
        <div class="col-md-3">
            <label for="name" class="form-label">Nombre</label>
            <input  type="text"
                    name="name"
                    id="name"
                    class="form-control"
                    value="{{ request('name') }}"
                    placeholder="Buscar por nombre">
        </div>

        {{-- Correo --}}
        <div class="col-md-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input  type="email"
                    name="email"
                    id="email"
                    class="form-control"
                    value="{{ request('email') }}"
                    placeholder="Buscar por correo">
        </div>

        {{-- Rol --}}
        <div class="col-md-2">
            <label for="role" class="form-label">Rol</label>
            <select name="role" id="role" class="form-select">
                <option value="">Todos</option>
                <option value="admin" {{ request('role')=='admin' ? 'selected' : '' }}>Admin</option>
                <option value="user"  {{ request('role')=='user'  ? 'selected' : '' }}>Usuario</option>
            </select>
        </div>

        {{-- Estado (Activo / Inactivo) --}}
        <div class="col-md-2">
            <label for="is_active" class="form-label">Estado</label>
            <select name="is_active" id="is_active" class="form-select">
                <option value="">Todos</option>
                <option value="1" {{ request('is_active')==='1' ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ request('is_active')==='0' ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>

        {{-- Botones --}}
        <div class="col-md-2 d-flex align-items-end gap-2">
            <button type="submit" class="btn btn-primary w-100">Filtrar</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary w-100">Limpiar</a>
        </div>

    </div>
</form>

        <!-- Info + paginación (arriba) -->
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
                @if($users->total())
                    <span>Mostrando {{ $users->firstItem() }}-{{ $users->lastItem() }} de {{ $users->total() }} resultados</span>
                @endif
            </div>
            <div>
                {{ $users->withQueryString()->links('pagination::bootstrap-4') }}
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
                        <th>Activo</th>
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
                            @if($user->is_active)
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-secondary">Inactivo</span>
                            @endif
                        </td>
                        <td class="d-flex gap-1">
                            <a href="{{ route('admin.users.edit', $user) }}"
                               class="btn btn-sm btn-primary">
                                <i class="fa-solid fa-pen"></i>
                                Editar
                            </a>

                            <form  action="{{ route('admin.users.destroy', $user) }}"
                                   method="POST"
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

        <!-- Paginación (abajo) -->
        {{ $users->withQueryString()->links('pagination::bootstrap-4') }}
    </div>
</x-admin-layout>
