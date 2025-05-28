<!-- resources/views/inventarios/detalles_transferencias/index.blade.php -->
@php use Illuminate\Support\Str; @endphp

<x-admin-layout>
    <x-slot name="title">Inventario Documental</x-slot>

    <div class="container-fluid">
        <h1 class="mb-4">Inventario Documental</h1>

        {{-- FILTROS --}}
        <form method="GET" action="{{ route('inventarios.detalles_transferencias.index') }}" class="card card-body mb-4">
            <div class="row gx-2 gy-3">
                <div class="col-md-3">
                    <label class="form-label">Dependencia</label>
                    <select name="entidad_productora_id" class="form-select form-select-sm">
                        <option value="">— Todas —</option>
                        @foreach ($dependencias as $id => $nombre)
                            <option value="{{ $id }}"
                                {{ request('entidad_productora_id') == $id ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Serie</label>
                    <select name="serie_id" class="form-select form-select-sm">
                        <option value="">— Todas —</option>
                        @foreach ($series as $id => $nombre)
                            <option value="{{ $id }}" {{ request('serie_id') == $id ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Subserie</label>
                    <select name="subserie_id" class="form-select form-select-sm">
                        <option value="">— Todas —</option>
                        @foreach ($subseries as $id => $nombre)
                            <option value="{{ $id }}" {{ request('subserie_id') == $id ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Estado Flujo</label>
                    <select name="estado_flujo" class="form-select form-select-sm">
                        <option value="">— Todos —</option>
                        @foreach ($estados as $key => $label)
                            <option value="{{ $key }}"
                                {{ request('estado_flujo') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">F. Inicial Desde</label>
                    <input type="date" name="fecha_inicial_desde" class="form-control form-control-sm"
                        value="{{ request('fecha_inicial_desde') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">F. Inicial Hasta</label>
                    <input type="date" name="fecha_inicial_hasta" class="form-control form-control-sm"
                        value="{{ request('fecha_inicial_hasta') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Buscar (código, orden, obs.)</label>
                    <input type="text" name="busqueda" class="form-control form-control-sm" placeholder="Buscar..."
                        value="{{ request('busqueda') }}">
                </div>
                <div class="col-md-3 align-self-end">
                    <button class="btn btn-primary w-100">
                        <i class="fa fa-filter me-1"></i> Aplicar
                    </button>
                </div>
                <div class="col-md-3 align-self-end">
                    <a href="{{ route('inventarios.detalles_transferencias.index') }}"
                        class="btn btn-outline-secondary w-100">Limpiar</a>
                </div>
            </div>
        </form>

        {{-- RESUMEN + PAGINACIÓN --}}
        <div class="d-flex justify-content-between align-items-center mb-2">
            <small>
                Mostrando {{ $detalles->firstItem() }}–{{ $detalles->lastItem() }}
                de {{ $detalles->total() }}
            </small>
            {{ $detalles->withQueryString()->links('pagination::bootstrap-4') }}
        </div>

        {{-- TABLA --}}
        <div class="table-responsive">
            <table class="table table-hover align-middle text-center">
                <caption class="text-start fw-semibold mb-2">Detalles del Inventario Documental</caption>
                <thead class="table-light">
                    <tr>
                        <th>N° Transferencia</th>
                        <th>Dependencia</th>
                        <th>N° Orden</th>
                        <th>Código</th>
                        <th>Serie</th>
                        <th>Subserie</th>
                        <th>F. Inicial</th>
                        <th>F. Final</th>
                        <th>Clasificación</th>
                        <th>Folios</th>
                        <th>Soporte</th>
                        <th>Ubicación</th>
                        <th>Frecuencia</th>
                        <th>Observaciones</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($detalles as $d)
                        <tr>
                            <td>{{ $d->transferencia->numero_transferencia }}</td>
                            <td>{{ optional($d->transferencia->entidadProductora)->nombre }}</td>
                            <td>{{ $d->numero_orden }}</td>
                            <td>{{ $d->codigo }}</td>
                            <td>{{ optional($d->serie)->nombre }}</td>
                            <td>{{ optional($d->subserie)->nombre }}</td>
                            <td>{{ $d->fecha_inicial?->format('d/m/Y') ?? '—' }}</td>
                            <td>{{ $d->fecha_final?->format('d/m/Y') ?? '—' }}</td>
                            <td class="text-start">
                                <small>
                                    <strong>Caja:</strong> {{ $d->caja }}<br>
                                    <strong>Carpeta:</strong> {{ $d->carpeta }}<br>
                                    <strong>Res.:</strong> {{ $d->resolucion }}<br>
                                    <strong>Tomo:</strong> {{ $d->tomo }}
                                </small>
                            </td>
                            <td>{{ $d->numero_folios }}</td>
                            <td>{{ optional($d->soporte)->nombre }}</td>
                            <td class="text-start">
                                <small>
                                    <strong>Estante:</strong> {{ optional($d->ubicacion)->estante ?? '—' }}<br>
                                    <strong>Bandeja:</strong> {{ optional($d->ubicacion)->bandeja ?? '—' }}<br>
                                    <strong>Caja:</strong> {{ optional($d->ubicacion)->caja ?? '—' }}<br>
                                    <strong>Carpeta:</strong> {{ optional($d->ubicacion)->carpeta ?? '—' }}<br>
                                    @if (optional($d->ubicacion)->otro)
                                        <strong>Otro:</strong> {{ $d->ubicacion->otro }}
                                    @endif
                                </small>
                            </td>
                            <td>{{ $d->frecuencia_consulta }}</td>
                            <td>{{ Str::limit($d->observaciones, 30) }}</td>
                            <td>
                                @php $st = Str::lower($d->estado_flujo); @endphp
                                <span
                                    class="badge {{ $st === 'activo' ? 'bg-success' : ($st === 'prestado' ? 'bg-warning text-dark' : 'bg-danger') }}">
                                    {{ ucfirst($st) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="16" class="text-center">No se encontraron detalles.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINACIÓN FINAL --}}
        <div class="d-flex justify-content-end mt-3">
            {{ $detalles->withQueryString()->links('pagination::bootstrap-4') }}
        </div>
    </div>
</x-admin-layout>
