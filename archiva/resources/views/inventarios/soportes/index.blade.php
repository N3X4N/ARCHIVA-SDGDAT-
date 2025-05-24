{{-- resources/views/inventarios/soportes/index.blade.php --}}
<x-admin-layout>
    <x-slot name="title">Gestión de Soportes</x-slot>

    <div class="container-fluid">
        {{-- Header: título + botón --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Lista de Soportes</h1>
            <a href="{{ route('inventarios.soportes.create') }}" class="btn btn-success">
                <i class="fa fa-plus me-1"></i> Nuevo Soporte
            </a>
        </div>

        {{-- Formulario de filtros --}}
        <form method="GET" action="{{ route('inventarios.soportes.index') }}">
            <div class="row g-3 align-items-end mb-4">
                <div class="col-md-4">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control"
                        placeholder="Buscar por nombre" value="{{ request('nombre') }}">
                </div>
                <div class="col-md-3">
                    <label for="is_active" class="form-label">Estado</label>
                    <select name="is_active" id="is_active" class="form-control">
                        <option value="">Todos</option>
                        <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fa fa-filter me-1"></i> Filtrar
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('inventarios.soportes.index') }}" class="btn btn-outline-secondary w-100">
                        Limpiar
                    </a>
                </div>
            </div>
        </form>

        {{-- Paginación: resumen + links --}}
        <div class="d-flex justify-content-between align-items-center mt-4 mb-2">
            <div>
                <small>
                    Mostrando {{ $soportes->firstItem() }}
                    a {{ $soportes->lastItem() }}
                    de {{ $soportes->total() }} resultados
                </small>
            </div>
            <div>
                {{ $soportes->links('pagination::bootstrap-4') }}
            </div>
        </div>

        {{-- Tabla de soportes --}}
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th style="width: 180px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($soportes as $s)
                        <tr>
                            <td>{{ $s->nombre }}</td>
                            <td>{{ $s->descripcion }}</td>
                            <td>
                                <i
                                    class="fa {{ $s->is_active ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }}"></i>
                                {{ $s->is_active ? 'Activo' : 'Inactivo' }}
                            </td>
                            <td class="d-flex justify-content-center gap-1">
                                <a href="{{ route('inventarios.soportes.edit', $s) }}" class="btn btn-sm btn-primary">
                                    <i class="fa-solid fa-pen"></i> Editar
                                </a>
                                <form action="{{ route('inventarios.soportes.destroy', $s) }}" method="POST"
                                    class="d-inline js-confirmable"
                                    data-confirm-message="¿Eliminar soporte «{{ $s->nombre }}»?">
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

        {{-- Links al final --}}
        <div class="d-flex justify-content-end mt-3">
            {{ $soportes->links('pagination::bootstrap-4') }}
        </div>
    </div>
</x-admin-layout>
