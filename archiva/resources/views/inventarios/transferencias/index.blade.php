<x-admin-layout>
    <x-slot name="title">Inventario Documental</x-slot>

    <div class="container-fluid">
        <h1 class="mb-4">Inventario Documental</h1>

        <a href="{{ route('inventarios.transferencias.create') }}" class="btn btn-success mb-3">
            Nueva Transferencia
        </a>

        <form method="GET" action="{{ route('inventarios.transferencias.index') }}">
            <div class="row">
                <div class="col-md-3">
                    <label for="dependencia_id">Dependencia</label>
                    <select name="dependencia_id" class="form-control">
                        <option value="">Seleccione...</option>
                        @foreach ($dependencias as $id => $nombre)
                            <option value="{{ $id }}"
                                {{ request('dependencia_id') == $id ? 'selected' : '' }}>
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
                            <option value="{{ $key }}" {{ request('estado_flujo') == $key ? 'selected' : '' }}>
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
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transferencias as $t)
                    <tr>
                        <td style="font-size: 0.8em;">{{ $t->id }}</td>
                        <td>{{ $t->entidad_productora }}</td>
                        <td>{{ $t->entidad_productora }}</td>
                        <td>{{ $t->unidad_administrativa }}</td>
                        <td>{{ $t->oficina_productora }}</td>
                        <td>{{ \Carbon\Carbon::parse($t->registro_entrada)->format('Y-m-d') }}</td>
                        <td>{{ $t->objeto }}</td>
                        <td>{{ $t->estado_flujo }}</td>
                        <td>
                            <!-- Buttons with icons properly aligned -->
                            <div class="d-flex">
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
                                                <th>Otro</th>
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
                                    {{ $detalle->serie?->nombre }} / {{ $detalle->subserie?->nombre }}
                                @elseif($detalle->serie)
                                    <strong>{{ $detalle->serie?->nombre }}</strong>
                                @else
                                    <em>Sin serie asignada</em>
                                @endif
                            </td>
                            <td>{{ $detalle->fecha_inicial }}</td>
                            <td>{{ $detalle->fecha_final }}</td>
                            <td>{{ $detalle->caja }}</td>
                            <td>{{ $detalle->carpeta }}</td>
                            <td>{{ $detalle->resolucion }}</td>
                            <td>{{ $detalle->otro }}</td>
                            <td>{{ $detalle->numero_folios }}</td>
                            <td>{{ $detalle->soporte }}</td>
                            <td>{{ $detalle->frecuencia_consulta }}</td>
                            <td>{{ $detalle->ubicacion_caja . ' - ' . $detalle->ubicacion_bandeja . ' - ' . $detalle->ubicacion_estante }}
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
