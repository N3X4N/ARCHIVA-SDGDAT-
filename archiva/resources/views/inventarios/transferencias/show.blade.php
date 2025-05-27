@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Transferencia #{{ $transferencia->numero_transferencia }}</h1>
        <div class="btn-toolbar">
            {{-- Botón PDF --}}
            <a href="{{ route('inventarios.transferencias.pdf', $transferencia) }}"
               class="btn btn-sm btn-outline-danger rounded-pill me-2"
               target="_blank" rel="noopener"
               title="Exportar PDF">
                <svg class="bi bi-file-earmark-pdf me-1" width="1em" height="1em" fill="currentColor">
                    <use xlink:href="#file-earmark-pdf-fill"/>
                </svg>
                PDF
            </a>
            {{-- Editar --}}
            @can('update', $transferencia)
                <a href="{{ route('inventarios.transferencias.edit', $transferencia) }}"
                   class="btn btn-sm btn-primary me-2">
                    <i class="fas fa-edit"></i> Editar
                </a>
            @endcan
            {{-- Eliminar --}}
            @can('delete', $transferencia)
                <form action="{{ route('inventarios.transferencias.destroy', $transferencia) }}"
                      method="POST"
                      class="d-inline"
                      onsubmit="return confirm('¿Eliminar esta transferencia?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">
                        <i class="fas fa-trash-alt"></i> Eliminar
                    </button>
                </form>
            @endcan
        </div>
    </div>

    {{-- Cabecera de datos --}}
    <div class="row mb-4">
        <div class="col-md-6">
            <table class="table table-sm table-borderless">
                <tr>
                    <th>Entidad Remitente:</th>
                    <td>{{ $transferencia->entidadRemitente->nombre }}</td>
                </tr>
                <tr>
                    <th>Entidad Productora:</th>
                    <td>{{ $transferencia->entidadProductora->nombre }}</td>
                </tr>
                <tr>
                    <th>Oficina Productora:</th>
                    <td>{{ $transferencia->oficinaProductora->nombre }}</td>
                </tr>
                <tr>
                    <th>Unidad Administrativa:</th>
                    <td>{{ $transferencia->unidad_administrativa }}</td>
                </tr>
                <tr>
                    <th>Registro Entrada:</th>
                    <td>{{ $transferencia->registro_entrada->format('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <th>Objeto:</th>
                    <td>{{ $transferencia->objeto }}</td>
                </tr>
            </table>
        </div>
        <div class="col-md-6 text-end">
            <table class="table table-sm table-borderless">
                <tr>
                    <th>Número T:</th>
                    <td>{{ $transferencia->numero_transferencia }}</td>
                </tr>
                <tr>
                    <th>Estado Flujo:</th>
                    <td>{{ \App\Models\TransferenciaDocumental::ESTADOS[$transferencia->estado_flujo] }}</td>
                </tr>
                <tr>
                    <th>Creado por:</th>
                    <td>{{ optional($transferencia->user->perfil)->nombres ?? $transferencia->user->email }}</td>
                </tr>
                <tr>
                    <th>Fecha Creación:</th>
                    <td>{{ $transferencia->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            </table>
        </div>
    </div>

    {{-- Detalles --}}
    <div class="table-responsive mb-4">
        <table class="table table-sm table-striped table-bordered">
            <thead class="table-secondary">
                <tr>
                    <th>#</th>
                    <th>Código</th>
                    <th>Serie / Subserie</th>
                    <th>Fechas</th>
                    <th>Conservación</th>
                    <th>Fº Folios</th>
                    <th>Soporte</th>
                    <th>Frecuencia</th>
                    <th>Ubicación</th>
                    <th>Obs.</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transferencia->detalles as $det)
                    <tr>
                        <td>{{ $det->numero_orden }}</td>
                        <td>{{ $det->codigo }}</td>
                        <td>
                            @if($det->subserie)
                                {{ $det->serie->nombre }} / {{ $det->subserie->nombre }}
                            @else
                                {{ $det->serie->nombre }}
                            @endif
                        </td>
                        <td>
                            {{ optional($det->fecha_inicial)->format('Y-m-d') }}
                            &ndash;
                            {{ optional($det->fecha_final)->format('Y-m-d') }}
                        </td>
                        <td>
                            Caja: {{ $det->caja }}<br>
                            Carpeta: {{ $det->carpeta }}<br>
                            Tomo: {{ $det->tomo }}<br>
                            Otro: {{ $det->otro }}
                        </td>
                        <td class="text-center">{{ $det->numero_folios }}</td>
                        <td>{{ optional($det->soporte)->nombre ?? '–' }}</td>
                        <td>{{ $det->frecuencia_consulta }}</td>
                        <td>
                            C: {{ optional($det->ubicacion)->caja }}<br>
                            B: {{ optional($det->ubicacion)->bandeja }}<br>
                            E: {{ optional($det->ubicacion)->estante }}
                        </td>
                        <td>{{ $det->observaciones }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Firmas --}}
    <div class="row text-center">
        @php
            function firmaData($user) {
                $u    = optional($user);
                $p    = optional($u->perfil);
                $dep  = optional($p->dependencia)->nombre;
                return [
                  'nombre'      => trim(($p->nombres ?? '') . ' ' . ($p->apellidos ?? '')),
                  'dependencia' => $dep,
                ];
            }
            $fElab = firmaData($transferencia->elaboradoBy);
            $fEnt  = firmaData($transferencia->entregadoBy);
            $fRec  = firmaData($transferencia->recibidoBy);
        @endphp

        <div class="col-md-4">
            <strong>ELABORADO POR:</strong><br>
            {{ $fElab['nombre'] }}<br>
            <em>{{ $fElab['dependencia'] }}</em><br>
            <small>{{ $transferencia->elaborado_fecha?->format('d/m/Y H:i') }}</small>
        </div>
        <div class="col-md-4">
            <strong>ENTREGADO POR:</strong><br>
            {{ $fEnt['nombre'] }}<br>
            <em>{{ $fEnt['dependencia'] }}</em><br>
            <small>{{ $transferencia->entregado_fecha?->format('d/m/Y H:i') }}</small>
        </div>
        <div class="col-md-4">
            <strong>RECIBIDO POR:</strong><br>
            {{ $fRec['nombre'] }}<br>
            <em>{{ $fRec['dependencia'] }}</em><br>
            <small>{{ $transferencia->recibido_fecha?->format('d/m/Y H:i') }}</small>
        </div>
    </div>
</div>
@endsection
