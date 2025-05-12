<x-admin-layout>
    <x-slot name="title">Gestión de Roles</x-slot>

    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Lista de Roles</h1>
            <a href="{{ route('admin.roles.create') }}" class="btn btn-success">
                <i class="fa fa-plus me-1"></i> Nuevo Rol
            </a>
        </div>

        {{-- FILTROS --}}
        <form method="GET" action="{{ route('admin.roles.index') }}">
            <div class="row g-3 align-items-end">                
                {{-- Nombre --}}
                <div class="col-md-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" name="name" id="name" class="form-control"
                        placeholder="Buscar por nombre" value="{{ request('nombre_rol') }}">
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
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary w-100">
                        Limpiar filtros
                    </a>
                </div>
            </div>
        </form>

        {{-- RESULTADOS / PAGINACIÓN --}}
        <div class="d-flex justify-content-between align-items-center mt-4 mb-2">
            <small>
                Mostrando {{ $roles->firstItem() }} a {{ $roles->lastItem() }} de {{ $roles->total() }} resultados
            </small>
            <div>
                {{ $roles->links('pagination::bootstrap-5') }}
            </div>
        </div>

        {{-- TABLA --}}
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th style="width:180px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                        <tr>
                            <td>{{ $role->nombre_rol }}</td>
                            <td>{{ $role->description }}</td>
                            <td>
                                <i
                                    class="fa {{ $role->is_active ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }}"></i>
                                {{ $role->is_active ? 'Activo' : 'Inactivo' }}
                            </td>
                            <td class="d-flex justify-content-center gap-1">
                                <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-pen me-1"></i> Editar
                                </a>
                                <form action="{{ route('admin.roles.destroy', $role) }}" method="POST"
                                    class="d-inline js-confirmable"
                                    data-confirm-message="¿Eliminar rol «{{ $role->name }}»?">
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
