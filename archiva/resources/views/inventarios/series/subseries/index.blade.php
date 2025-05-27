<!-- resources/views/inventarios/series/subseries/index.blade.php -->
<x-admin-layout>
    <x-slot name="title">Subseries de {{ $series->nombre }}</x-slot>

    <div class="container-fluid">
        {{-- Cabecera con título y botones --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Subseries de {{ $series->nombre }}</h1>
            <div>
                <a href="{{ route('inventarios.series.index', ['series' => $series->id]) }}"
                    class="btn btn-outline-secondary btn-sm">
                    <i class="fa fa-arrow-left me-1"></i> Volver
                </a>
                <a href="{{ route('inventarios.series.subseries.create', $series) }}" class="btn btn-success">
                    <i class="fa fa-plus me-1"></i> Nueva Subserie
                </a>
            </div>
        </div>

        {{-- Filtros --}}
        <form method="GET" action="{{ route('inventarios.series.subseries.index', $series) }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Código</label>
                    <input type="text" name="codigo" class="form-control" placeholder="Buscar por código"
                        value="{{ request('codigo') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" placeholder="Buscar por nombre"
                        value="{{ request('nombre') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Estado</label>
                    <select name="is_active" class="form-select">
                        <option value="">Todos</option>
                        <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-filter me-1"></i> Filtrar
                    </button>
                </div>
                <div class="col-auto">
                    <a href="{{ route('inventarios.series.subseries.index', $series) }}"
                        class="btn btn-outline-secondary">Limpiar filtros</a>
                </div>
            </div>
        </form>

        {{-- Resultado y paginación --}}
        <div class="d-flex justify-content-between align-items-center mt-4 mb-2">
            <small>
                Mostrando {{ $subseries->firstItem() }} a {{ $subseries->lastItem() }}
                de {{ $subseries->total() }} resultados
            </small>
            <div>
                {{ $subseries->links('pagination::bootstrap-5') }}
            </div>
        </div>

        {{-- Tabla --}}
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Dependencias</th>
                        <th>Estado</th>
                        <th style="width:180px">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subseries as $sub)
                        <tr>
                            <td>{{ $sub->codigo }}</td>
                            <td>{{ $sub->nombre }}</td>
                            <td>
                                @foreach ($sub->dependencias as $dep)
                                    <span class="badge bg-secondary">{{ $dep->sigla }}</span>
                                @endforeach
                            </td>
                            <td>
                                @if ($sub->is_active)
                                    <i class="fa fa-check-circle text-success"></i> Activo
                                @else
                                    <i class="fa fa-times-circle text-danger"></i> Inactivo
                                @endif
                            </td>
                            <td class="d-flex justify-content-center gap-1">
                                <a href="{{ route('inventarios.series.subseries.edit', [
                                    'series' => $series->id,
                                    'subseries' => $sub->id,
                                ]) }}"
                                    class="btn btn-sm btn-primary">
                                    Editar
                                </a>
                                <form
                                    action="{{ route('inventarios.series.subseries.destroy', [
                                        'series' => $series->id,
                                        'subseries' => $sub->id,
                                    ]) }}"
                                    method="POST" class="d-inline js-confirmable"
                                    data-confirm-message="¿Eliminar subserie «{{ $sub->nombre }}»?">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No hay subseries registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
