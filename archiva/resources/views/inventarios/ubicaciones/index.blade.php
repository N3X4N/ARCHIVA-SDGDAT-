<x-admin-layout>
    <x-slot name="title">Gestión de Ubicaciones</x-slot>

    <div class="container-fluid">
        {{-- Header: título + botón --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Lista de Ubicaciones</h1>
            <a href="{{ route('inventarios.ubicaciones.create') }}" class="btn btn-success">
                <i class="fa fa-plus me-1"></i> Nueva Ubicación
            </a>
        </div>

        {{-- Formulario de filtros (por estante) --}}
        <form method="GET" action="{{ route('inventarios.ubicaciones.index') }}">
            <div class="row g-3 align-items-end mb-4">
                <div class="col-md-3">
                    <label for="estante" class="form-label">Estante</label>
                    <input type="text" name="estante" id="estante" class="form-control"
                        placeholder="Buscar por estante" value="{{ request('estante') }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fa fa-filter me-1"></i> Filtrar
                    </button>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('inventarios.ubicaciones.index') }}" class="btn btn-outline-secondary w-100">
                        Limpiar filtros
                    </a>
                </div>
            </div>
        </form>

        {{-- Paginación: resumen + links --}}
        <div class="d-flex justify-content-between align-items-center mt-4 mb-2">
            <div>
                <small>
                    Mostrando {{ $ubicaciones->firstItem() }}
                    a {{ $ubicaciones->lastItem() }}
                    de {{ $ubicaciones->total() }} resultados
                </small>
            </div>
            <div>
                {{ $ubicaciones->links('pagination::bootstrap-4') }}
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>Estante</th>
                        <th>Bandeja</th>
                        <th>Caja</th>
                        <th>Carpeta</th>
                        <th>Otro</th>
                        <th>Estado</th>
                        <th style="width: 180px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ubicaciones as $u)
                        <tr>
                            <td>{{ $u->estante }}</td>
                            <td>{{ $u->bandeja }}</td>
                            <td>{{ $u->caja }}</td>
                            <td>{{ $u->carpeta }}</td>
                            <td>{{ $u->otro }}</td>
                            <td>
                                <i
                                    class="fa {{ $u->is_active ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }}"></i>
                                {{ $u->is_active ? 'Activo' : 'Inactivo' }}
                            </td>
                            <td class="d-flex justify-content-center gap-1">
                                <a href="{{ route('inventarios.ubicaciones.edit', $u) }}"
                                    class="btn btn-sm btn-primary">
                                    <i class="fa-solid fa-pen"></i> Editar
                                </a>
                                <form action="{{ route('inventarios.ubicaciones.destroy', $u) }}" method="POST"
                                    class="d-inline js-confirmable"
                                    data-confirm-message="¿Eliminar ubicación «{{ $u->estante }}/{{ $u->bandeja }}»?">
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

        <div class="d-flex justify-content-end mt-3">
            {{ $ubicaciones->links('pagination::bootstrap-4') }}
        </div>
    </div>
</x-admin-layout>
