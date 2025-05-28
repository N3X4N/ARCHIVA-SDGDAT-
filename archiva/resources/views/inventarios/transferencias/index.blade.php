<x-admin-layout>
    <x-slot name="title">Inventario Documental</x-slot>

    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Lista de Transferencias</h1>
            <a href="{{ route('inventarios.transferencias.create') }}" class="btn btn-success">
                <i class="fa fa-plus me-1"></i> Nueva Transferencia
            </a>
        </div>

        <form method="GET" action="{{ route('inventarios.transferencias.index') }}">
            <div class="row">
                {{-- Filtro Entidad Remitente --}}
                <div class="col-md-3">
                    <label for="entidad_remitente_id">Entidad Remitente</label>
                    <select name="entidad_remitente_id" class="form-control">
                        <option value="">Seleccione...</option>
                        @foreach ($dependencias as $id => $nombre)
                            <option value="{{ $id }}"
                                {{ request('entidad_remitente_id') == $id ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Filtro Entidad Productora --}}
                <div class="col-md-3">
                    <label for="entidad_productora_id">Entidad Productora</label>
                    <select name="entidad_productora_id" class="form-control">
                        <option value="">Seleccione...</option>
                        @foreach ($dependencias as $id => $nombre)
                            <option value="{{ $id }}"
                                {{ request('entidad_productora_id') == $id ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Filtro Oficina Productora --}}
                <div class="col-md-3">
                    <label for="oficina_productora_id">Oficina Productora</label>
                    <select name="oficina_productora_id" class="form-control">
                        <option value="">Seleccione...</option>
                        @foreach ($dependencias as $id => $nombre)
                            <option value="{{ $id }}"
                                {{ request('oficina_productora_id') == $id ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="estado_flujo">Estado</label>
                    <select name="estado_flujo" class="form-control">
                        <option value="">Seleccione...</option>
                        @foreach ($estados as $key => $estado)
                            <option value="{{ $key }}"
                                {{ request('estado_flujo') == $key ? 'selected' : '' }}>
                                {{ $estado }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="fecha_inicio">Fecha de Registro</label>
                    <input type="date" name="fecha_inicio" class="form-control"
                        value="{{ request('fecha_inicio') }}">
                </div>

                <div class="col-md-3">
                    <label for="fecha_fin">A</label>
                    <input type="date" name="fecha_fin" class="form-control" value="{{ request('fecha_fin') }}">
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Aplicar Filtros</button>
            <a href="{{ route('inventarios.transferencias.index') }}" class="btn btn-secondary mt-3">Limpiar
                Filtros</a>

            <div class="mt-3 mb-4">
                <a href="{{ route('inventarios.transferencias.pdf_all', request()->query()) }}"
                    class="btn btn-sm btn-outline-danger" target="_blank" rel="noopener">
                    <i class="fas fa-file-pdf me-1"></i> Exportar Listado PDF
                </a>

            </div>
        </form>

        <br>

        <div class="d-flex justify-content-between align-items-center">
            <div>
                <span>Mostrando {{ $transferencias->firstItem() }} a {{ $transferencias->lastItem() }} de
                    {{ $transferencias->total() }} resultados</span>
            </div>
            <div>
                {{ $transferencias->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped w-100">
            <thead>
                <tr>
                    <th style="width: 10%;">Número de Transferencia</th>
                    <th>Entidad Remitente</th>
                    <th>Entidad Productora</th>
                    <th>Unidad Administrativa</th>
                    <th>Oficina Productora</th>
                    <th>Registro de Entrada</th>
                    <th>Objeto</th>
                    <th>Estado</th>
                    <th>Aprobaciones</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transferencias as $t)
                    <tr>
                        <td style="font-size: 0.8em;">{{ $t->id }}</td>
                        <td>{{ $t->entidadRemitente->nombre ?? '—' }}</td>
                        <td>{{ $t->entidadProductora->nombre ?? '—' }}</td>
                        <td>{{ $t->unidad_administrativa }}</td>
                        <td>{{ $t->oficinaProductora->nombre ?? '—' }}</td>
                        <td>{{ \Carbon\Carbon::parse($t->registro_entrada)->format('Y-m-d') }}</td>
                        <td>{{ $t->objeto }}</td>
                        <td>{{ $t->estado_flujo }}</td>
                        <td class="align-middle">
                            <div class="d-flex flex-column gap-2">
                                {{-- 1) Firmar Entregado (solo en ELABORADO) --}}
                                @can('entregar', $t)
                                    <form method="POST"
                                        action="{{ route('inventarios.transferencias.firmar.entregado', $t) }}">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-warning">
                                            <i class="fas fa-pen-nib me-1"></i> Firmar Entregado
                                        </button>
                                    </form>
                                @endcan

                                {{-- 2) Firmar Recibido (solo en ENTREGADO) --}}
                                @can('recibir', $t)
                                    <form method="POST"
                                        action="{{ route('inventarios.transferencias.firmar.recibido', $t) }}">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="fas fa-check-circle me-1"></i> Firmar Recibido
                                        </button>
                                    </form>
                                @endcan

                                {{-- 3) Archivar (solo en RECIBIDO) --}}
                                @can('archivar', $t)
                                    <form method="POST" action="{{ route('inventarios.transferencias.archivar', $t) }}">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="fas fa-archive me-1"></i> Archivar
                                        </button>
                                    </form>
                                @endcan

                                {{-- 4) Historial de firmas --}}
                                @if ($t->elaborado_por)
                                    <small class="text-muted mb-0">
                                        Elaborado por {{ $t->elaboradoBy->name }}
                                        ({{ $t->elaborado_fecha->format('d/m/Y H:i') }})
                                    </small>
                                @endif
                                @if ($t->entregado_por)
                                    <small class="text-muted mb-0">
                                        Entregado por {{ $t->entregadoBy->name }}
                                        ({{ $t->entregado_fecha->format('d/m/Y H:i') }})
                                    </small>
                                @endif
                                @if ($t->recibido_por)
                                    <small class="text-muted mb-0">
                                        Recibido por {{ $t->recibidoBy->name }}
                                        ({{ $t->recibido_fecha->format('d/m/Y H:i') }})
                                    </small>
                                @endif

                                {{-- 5) Badge final si ya está archivado --}}
                                @if ($t->estado_flujo === 'ARCHIVADO')
                                    <span class="badge bg-success mt-2">✔ Completo</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <!-- Buttons with icons properly aligned -->
                            <div class="d-flex">
                                <!-- Botón PDF -->
                                <a href="{{ route('inventarios.transferencias.pdf', $t) }}"
                                    class="btn btn-sm btn-outline-danger me-2" title="Exportar PDF" target="_blank"
                                    rel="noopener">
                                    <i class="fas fa-file-pdf me-1"></i>PDF
                                </a>


                                <a href="{{ route('inventarios.transferencias.edit', $t) }}"
                                    class="btn btn-sm btn-primary mr-2">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('inventarios.transferencias.destroy', $t) }}" method="POST"
                                    onsubmit="return confirm('¿Eliminar esta transferencia?')" class="mb-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash-alt"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    @foreach ($t->detalles as $index => $detalle)
                        @if ($index === 0)
                            <tr>
                                <td colspan="8">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>N° Orden</th>
                                                <th>Código</th>
                                                <th>Serie / Subserie</th>
                                                <th>Fecha Inicial</th>
                                                <th>Fecha Final</th>
                                                <th>Caja</th>
                                                <th>Carpeta</th>
                                                <th>Resolución</th>
                                                <th>N° Folios</th>
                                                <th>Soporte</th>
                                                <th>Frecuencia de Consulta</th>
                                                <th>Ubicación</th>
                                                <th>Observaciones</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                        @endif
                        <tr>
                            <td>{{ $detalle->numero_orden }}</td>
                            <td>{{ $detalle->codigo }}</td>
                            <td>
                                @if ($detalle->subserie)
                                    {{-- Si tiene subserie, muestro **solo** la subserie --}}
                                    {{ $detalle->subserie->nombre }}
                                @elseif ($detalle->serie)
                                    {{-- Si no, muestro la serie en negrita --}}
                                    <strong>{{ $detalle->serie->nombre }}</strong>
                                @else
                                    <em>Sin serie asignada</em>
                                @endif
                            </td>
                            <td>{{ $detalle->fecha_inicial }}</td>
                            <td>{{ $detalle->fecha_final }}</td>
                            <td>{{ $detalle->caja }}</td>
                            <td>{{ $detalle->carpeta }}</td>
                            <td>{{ $detalle->resolucion }}</td>
                            <td>{{ $detalle->numero_folios }}</td>
                            <td>{{ optional($detalle->soporte)->nombre }}</td>
                            <td>{{ $detalle->frecuencia_consulta }}</td>
                            <td>
                                @if ($detalle->ubicacion)
                                    {{-- Asumo que tu relación es detalle->ubicacion --}}
                                    Estante: {{ $detalle->ubicacion->estante }} |
                                    Bandeja: {{ $detalle->ubicacion->bandeja }} |
                                    Caja: {{ $detalle->ubicacion->caja }} |
                                    Carpeta: {{ $detalle->ubicacion->carpeta }} |
                                    Otro: {{ $detalle->ubicacion->otro }}
                                @else
                                    – –
                                @endif
                            </td>
                            <td>{{ $detalle->observaciones }}</td>
                            <td>{{ $detalle->estado_flujo }}</td>
                        </tr>
                        @if ($index === count($t->detalles) - 1)
            </tbody>
        </table>
        </td>
        </tr>
        @endif
        @endforeach
        @endforeach
        </tbody>
        </table>
    </div>
</x-admin-layout>
