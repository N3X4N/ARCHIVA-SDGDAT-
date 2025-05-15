<x-admin-layout>
    <x-slot name="title">Gestión de Dependencias</x-slot>

    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Lista de Dependencias</h1>
            <a href="{{ route('inventarios.dependencias.create') }}" class="btn btn-success">
                <i class="fa fa-plus me-1"></i> Nueva Dependencia
            </a>
        </div>

        <!-- Formulario de filtros -->
        <form method="GET" action="{{ route('inventarios.dependencias.index') }}">
            <div class="row g-3 align-items-end">
                <!-- Filtro Nombre -->
                <div class="col-md-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="{{ request('nombre') }}"
                        placeholder="Buscar por nombre">
                </div>

                <!-- Filtro Estado -->
                <div class="col-md-3">
                    <label for="is_active" class="form-label">Estado</label>
                    <select name="is_active" class="form-control">
                        <option value="">Seleccione...</option>
                        <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>

                <!-- Botones -->
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fa fa-filter me-1"></i> Filtrar
                    </button>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('inventarios.dependencias.index') }}" class="btn btn-outline-secondary w-100">
                        Limpiar filtros
                    </a>
                </div>
            </div>
        </form>

        <!-- Paginación -->
        <div class="d-flex justify-content-between align-items-center mt-4 mb-2">
            <div>
                <small>
                    Mostrando {{ $dependencias->firstItem() }} a {{ $dependencias->lastItem() }} de
                    {{ $dependencias->total() }} resultados
                </small>
            </div>
            <div>
                {{ $dependencias->links('pagination::bootstrap-4') }}
            </div>
        </div>

        <!-- Tabla de Dependencias -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Sigla</th>
                        <th>Código</th>
                        <th>Estado</th>
                        <th style="width: 180px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dependencias as $dependencia)
                        <tr>
                            <td>{{ $dependencia->nombre }}</td>
                            <td>{{ $dependencia->sigla }}</td>
                            <td>{{ $dependencia->codigo }}</td>
                            <td>
                                <i
                                    class="fa {{ $dependencia->is_active ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }}"></i>
                                {{ $dependencia->is_active ? 'Activo' : 'Inactivo' }}
                            </td>
                            <td class="d-flex justify-content-center gap-1">
                                <a href="{{ route('inventarios.dependencias.edit', $dependencia) }}"
                                    class="btn btn-sm btn-primary">
                                    <i class="fa-solid fa-pen"></i> Editar
                                </a>
                                <form action="{{ route('inventarios.dependencias.destroy', $dependencia) }}" method="POST"
                                    class="d-inline js-confirmable"
                                    data-confirm-message="¿Eliminar dependencia «{{ $dependencia->nombre }}»?">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
