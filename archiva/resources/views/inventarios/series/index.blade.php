<x-admin-layout>
    <x-slot name="title">Series Documentales</x-slot>
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Series Documentales</h1>
            <a href="{{ route('inventarios.series.create') }}" class="btn btn-success">
                <i class="fa fa-plus me-1"></i> Nueva Serie
            </a>
        </div>

        {{-- Filtros --}}
        <form method="GET" action="{{ route('inventarios.series.index') }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Código</label>
                    <input type="text" name="codigo" class="form-control" placeholder="Buscar por código"
                        value="{{ request('codigo') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" placeholder="Buscar por nombre"
                        value="{{ request('nombre') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Tipo Documental</label>
                    <select name="tipo_documental_id" class="form-select">
                        <option value="">Todos</option>
                        @foreach ($tiposDocumentales as $id => $nombre)
                            <option value="{{ $id }}"
                                {{ request('tipo_documental_id') == $id ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Estado</label>
                    <select name="is_active" class="form-select">
                        <option value="">Todos</option>
                        <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>

                <div class="col-auto">
                    <button class="btn btn-primary">
                        <i class="fa fa-filter me-1"></i> Filtrar
                    </button>
                </div>
                <div class="col-auto">
                    <a href="{{ route('inventarios.series.index') }}" class="btn btn-outline-secondary">
                        Limpiar filtros
                    </a>
                </div>
            </div>
        </form>

        {{-- Pag y resumen --}}
        <div class="d-flex justify-content-between align-items-center mt-4 mb-2">
            <small>
                Mostrando {{ $series->firstItem() }} a {{ $series->lastItem() }}
                de {{ $series->total() }} resultados
            </small>
            <div>
                {{ $series->links('pagination::bootstrap-5') }}
            </div>
        </div>

        {{-- Tabla --}}
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Estado</th>
                        <th>Observaciones</th>
                        <th>Subseries</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($series as $s)
                        <tr>
                            <td>{{ $s->codigo }}</td>
                            <td>{{ $s->nombre }}</td>
                            <td>
                                {{ $s->tiposDocumentales->pluck('nombre')->join(', ') ?: '-' }}
                            </td>
                            <td>
                                @if ($s->is_active)
                                    <i class="fa fa-check-circle text-success"></i> Activo
                                @else
                                    <i class="fa fa-times-circle text-danger"></i> Inactivo
                                @endif
                            </td>

                            <td>{{ $s->observaciones }}</td>

                            <td class="text-center">
                                <a href="{{ route('inventarios.series.subseries.index', $s) }}"
                                    class="btn btn-sm btn-secondary">
                                    <i class="fa fa-stream me-1"></i> Ver Subseries
                                </a>
                            </td>

                            <td class="d-flex justify-content-center gap-1">
                                <a href="{{ route('inventarios.series.edit', $s) }}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-pen me-1"></i> Editar
                                </a>
                                <form action="{{ route('inventarios.series.destroy', $s) }}" method="POST"
                                    class="d-inline js-confirmable"
                                    data-confirm-message="¿Eliminar serie «{{ $s->nombre }}»?">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No hay series registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
