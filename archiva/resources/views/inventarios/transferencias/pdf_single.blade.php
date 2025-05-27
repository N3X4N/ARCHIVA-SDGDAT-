@php
    $path = public_path('assets/Imagen1.png');
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $logoData = base64_encode(file_get_contents($path));

    /**
     * Helpers para cada firma
     */
    function firmaData($userRelation)
    {
        // $userRelation es $transferencia->elaboradoBy, entregadoBy o recibidoBy
        $user = optional($userRelation);
        $perfil = optional($user->perfil);
        $depend = optional($perfil->dependencia)->nombre;
        $firma = $perfil->firma_digital; // ruta en storage/app/public/firmas/...
        $path = $firma ? storage_path("app/public/{$firma}") : null;

        return [
            'nombre' => trim(($perfil->nombres ?? '') . ' ' . ($perfil->apellidos ?? '')),
            'dependencia' => $depend,
            'firma_path' => $path && file_exists($path) ? $path : null,
        ];
    }

    $elab = firmaData($transferencia->elaboradoBy);
    $entg = firmaData($transferencia->entregadoBy);
    $reci = firmaData($transferencia->recibidoBy);
@endphp

<style>
    .pagenum:before {
        content: counter(page);
    }

    .pagecount:before {
        content: counter(pages);
    }
</style>

<table style="width:100%; border:1px solid #000; border-collapse: collapse; margin-bottom:2mm;">
    <tr>
        <!-- Logo: rowspan=2 -->
        <td rowspan="2"
            style="
            width:15%;
            border:1px solid #000;
            text-align:center;
            vertical-align:middle;
            padding:2px;
        ">
            <img src="data:image/{{ $type }};base64,{{ $logoData }}"
                style="width:80px; display:block; margin:0 auto;" alt="Logo Tabio">
            <div style="font-size:7pt; margin-top:1mm;">
                Alcaldía Municipal de Tabio
            </div>
        </td>

        <!-- Título 1: ocupa 2 columnas (35%+35%) -->
        <td colspan="2"
            style="
            border:1px solid #000;
            text-align:center;
            vertical-align:middle;
            padding:2px;
        ">
            <div style="font-size:11pt; font-weight:bold; line-height:1.1;">
                Proceso Gestión Documental y Archivo
            </div>
        </td>

        <!-- Meta: rowspan=2 -->
        <td rowspan="2"
            style="
            width:15%;
            border:1px solid #000;
            vertical-align:top;
            padding:0;
        ">
            <table style="width:100%; border:none; border-collapse:collapse; font-size:7pt;">
                <tr>
                    <th style="border:none; padding:2px; text-align:left;">Código:</th>
                    <td style="border:none; padding:2px;">260-GDA-F-1</td>
                </tr>
                <tr>
                    <th style="border:none; padding:2px; text-align:left;">Versión:</th>
                    <td style="border:none; padding:2px;">3.0</td>
                </tr>
                <tr>
                    <th style="border:none; padding:2px; text-align:left;">Fecha:</th>
                    <td style="border:none; padding:2px;">17/11/2020</td>
                </tr>
                <tr>
                    <th style="border:none; padding:2px; text-align:left;">Página:</th>
                    <td style="border:none; padding:2px;">1 de 1</td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <!-- Título 2: segunda fila, mismo colspan=2 -->
        <td colspan="2"
            style="
            border:1px solid #000;
            text-align:center;
            vertical-align:middle;
            padding:2px;
        ">
            <div style="font-size:10pt; font-weight:bold; line-height:1.1;">
                Formato único de inventario documental
            </div>
        </td>
    </tr>
</table>

{{-- BLOQUE DE INFO (tras la cabecera) --}}
<table style="width:100%; border:1px solid #000; border-collapse:collapse; margin-top:2mm; font-size:7pt;">
    <!-- 1) ENTIDAD / PRODUCTORA / Registro etiqueta -->
    <tr>
        <th style="width:15%; border:1px solid #000; padding:3px; text-align:left;">
            ENTIDAD REMITENTE:
        </th>
        <td style="width:20%; border:1px solid #000; padding:3px;">
            {{ $transferencia->entidadRemitente->nombre }}
        </td>
        <th style="width:15%; border:1px solid #000; padding:3px; text-align:left;">
            ENTIDAD PRODUCTORA:
        </th>
        <td style="width:20%; border:1px solid #000; padding:3px;">
            {{ $transferencia->entidadProductora->nombre }}
        </td>
        <th colspan="4" style="border:1px solid #000; padding:3px; text-align:center;">
            REGISTRO DE ENTRADA
        </th>
    </tr>

    <!-- 2) UNIDAD / OFICINA / Etiquetas Fecha -->
    <tr>
        <th style="border:1px solid #000; padding:3px; text-align:left;">
            UNIDAD ADMINISTRATIVA:
        </th>
        <td style="border:1px solid #000; padding:3px;">
            {{ $transferencia->unidad_administrativa }}
        </td>
        <th style="border:1px solid #000; padding:3px; text-align:left;">
            OFICINA PRODUCTORA:
        </th>
        <td style="border:1px solid #000; padding:3px;">
            {{ $transferencia->oficinaProductora->nombre }}
        </td>
        <th style="width:7%; border:1px solid #000; padding:3px; text-align:center;">AÑO</th>
        <th style="width:7%; border:1px solid #000; padding:3px; text-align:center;">MES</th>
        <th style="width:7%; border:1px solid #000; padding:3px; text-align:center;">DÍA</th>
        <th style="width:9%; border:1px solid #000; padding:3px; text-align:center;">N° T</th>
    </tr>

    <tr>
        <th colspan="4" rowspan="2"
            style="
            border:1px solid #000;
            padding:3px;
            padding-top:2px;      /* opcional: más espacio arriba */
            text-align:left;
            vertical-align: top;  /* aquí alineas el contenido arriba */
        ">
            OBJETO: {{ $transferencia->objeto }}
        </th>
        <td style="border:1px solid #000; padding:3px; text-align:center;">
            {{ $transferencia->registro_entrada->format('Y') }}
        </td>
        <td style="border:1px solid #000; padding:3px; text-align:center;">
            {{ $transferencia->registro_entrada->format('m') }}
        </td>
        <td style="border:1px solid #000; padding:3px; text-align:center;">
            {{ $transferencia->registro_entrada->format('d') }}
        </td>
        <td style="border:1px solid #000; padding:3px; text-align:center;">
            {{ $transferencia->numero_transferencia }}
        </td>
    </tr>
    <tr>
        <td colspan="4"
            style="
            border:1px solid #000;
            padding:3px;
            text-align:left;
            font-size:7pt;
        ">
            Número de Transferencia: {{ $transferencia->numero_transferencia }}
        </td>
    </tr>

</table>

{{-- TABLA DE DETALLES --}}
<table
    style="
    width:100%;
    border:1px solid #000;
    border-collapse:collapse;
    margin-top:2mm;
    font-size:7pt;
">
    <thead>
        <tr>
            <th rowspan="2" style="border:1px solid #000; padding:3px; text-align:center;">NÚMERO DE ORDEN</th>
            <th rowspan="2" style="border:1px solid #000; padding:3px; text-align:center;">CÓDIGO</th>
            <th rowspan="2" style="border:1px solid #000; padding:3px; text-align:center; width:20%;">NOMBRE DE LAS
                SERIES, SUBSERIE O ASUNTOS</th>
            <th colspan="2" style="border:1px solid #000; padding:3px; text-align:center;">FECHAS EXTREMAS</th>
            <th colspan="4" style="border:1px solid #000; padding:3px; text-align:center;">UNIDAD DE CONSERVACIÓN
            </th>
            <th rowspan="2" style="border:1px solid #000; padding:3px; text-align:center;">NÚMERO DE FOLIOS</th>
            <th rowspan="2" style="border:1px solid #000; padding:3px; text-align:center;">SOPORTE</th>
            <th rowspan="2" style="border:1px solid #000; padding:3px; text-align:center;">FRECUENCIA DE CONSULTA
            </th>
            <th colspan="3" style="border:1px solid #000; padding:3px; text-align:center;">UBICACIÓN</th>
            <th rowspan="2" style="border:1px solid #000; padding:3px; text-align:center;">OBSERVACIONES</th>
        </tr>
        <tr>
            <th style="border:1px solid #000; padding:3px; text-align:center;">INICIAL</th>
            <th style="border:1px solid #000; padding:3px; text-align:center;">FINAL</th>
            <th style="border:1px solid #000; padding:3px; text-align:center;">CAJA</th>
            <th style="border:1px solid #000; padding:3px; text-align:center;">CARPETA</th>
            <th style="border:1px solid #000; padding:3px; text-align:center;">TOMO</th>
            <th style="border:1px solid #000; padding:3px; text-align:center;">OTRO</th>
            <th style="border:1px solid #000; padding:3px; text-align:center;">CAJA</th>
            <th style="border:1px solid #000; padding:3px; text-align:center;">BANDEJA</th>
            <th style="border:1px solid #000; padding:3px; text-align:center;">ESTANTE</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transferencia->detalles as $detalle)
            <tr>
                {{-- 1. Número de orden --}}
                <td style="border:1px solid #000; padding:3px;">{{ $detalle->numero_orden }}</td>

                {{-- 2. Código --}}
                <td style="border:1px solid #000; padding:3px;">{{ $detalle->codigo }}</td>

                {{-- 3. Serie / Subserie --}}
                <td style="border:1px solid #000; padding:3px; text-align:left;">
                    @if ($detalle->subserie)
                        {{ $detalle->subserie->nombre }}
                    @elseif($detalle->serie)
                        <strong>{{ $detalle->serie->nombre }}</strong>
                    @else
                        –
                    @endif
                </td>

                {{-- 4–5. Fechas extremas --}}
                <td style="border:1px solid #000; padding:3px; text-align:center;">
                    {{ $detalle->fecha_inicial }}
                </td>
                <td style="border:1px solid #000; padding:3px; text-align:center;">
                    {{ $detalle->fecha_final }}
                </td>

                {{-- 6–9. Unidad de conservación --}}
                <td style="border:1px solid #000; padding:3px; text-align:center;">
                    {{ $detalle->caja }}
                </td>
                <td style="border:1px solid #000; padding:3px; text-align:center;">
                    {{ $detalle->carpeta }}
                </td>
                <td style="border:1px solid #000; padding:3px; text-align:center;">
                    {{ $detalle->tomo }}
                </td>
                <td style="border:1px solid #000; padding:3px; text-align:center;">
                    {{ $detalle->otro ?? '' }}
                </td>

                {{-- 10. Número de folios --}}
                <td style="border:1px solid #000; padding:3px; text-align:center;">
                    {{ $detalle->numero_folios }}
                </td>

                {{-- 11. Soporte --}}
                <td style="border:1px solid #000; padding:3px;">
                    {{ optional($detalle->soporte)->nombre }}
                </td>

                {{-- 12. Frecuencia de consulta --}}
                <td style="border:1px solid #000; padding:3px;">
                    {{ $detalle->frecuencia_consulta }}
                </td>

                {{-- 13–15. Ubicación: Caja, Bandeja, Estante --}}
                <td style="border:1px solid #000; padding:3px; text-align:center;">
                    {{ optional($detalle->ubicacion)->caja }}
                </td>
                <td style="border:1px solid #000; padding:3px; text-align:center;">
                    {{ optional($detalle->ubicacion)->bandeja }}
                </td>
                <td style="border:1px solid #000; padding:3px; text-align:center;">
                    {{ optional($detalle->ubicacion)->estante }}
                </td>

                {{-- 16. Observaciones --}}
                <td style="border:1px solid #000; padding:3px; text-align:left;">
                    {{ $detalle->observaciones }}
                </td>
            </tr>
        @endforeach
    </tbody>

</table>

<div style="page-break-inside: avoid; break-inside: avoid; margin-top: 4mm;">
    <table style="width:100%; border-collapse:collapse; font-size:10pt;">
        <tr>
            {{-- ELABORADO POR --}}
            <td style="width:33.33%; vertical-align:top; text-align:center; padding:0 2px;">
                <strong>ELABORADO POR:</strong><br>
                {{ $elab['nombre'] }}<br>
                <em>{{ $elab['dependencia'] }}</em><br>
                @if ($elab['firma_path'])
                    <img src="{{ $elab['firma_path'] }}"
                        style="
              width:90mm;
              height:auto;
              object-fit:contain;
              display:block;
              margin:2px auto;
            "
                        alt="Firma Elaborado">
                @else
                    <div style="border-bottom:1px solid #000; height:4mm; width:50%; margin:2px auto;"></div>
                @endif
                <br>
                <strong>LUGAR Y FECHA:</strong><br>
                @if ($transferencia->elaborado_fecha)
                    Tabio, {{ $transferencia->elaborado_fecha->format('d/m/Y H:i') }}
                @endif
            </td>

            {{-- ENTREGADO POR --}}
            <td style="width:33.33%; vertical-align:top; text-align:center; padding:0 2px;">
                <strong>ENTREGADO POR:</strong><br>
                {{ $entg['nombre'] }}<br>
                <em>{{ $entg['dependencia'] }}</em><br>
                @if ($entg['firma_path'])
                    <img src="{{ $entg['firma_path'] }}"
                        style="
              width:90mm;
              height:auto;
              object-fit:contain;
              display:block;
              margin:2px auto;
            "
                        alt="Firma Entregado">
                @else
                    <div style="border-bottom:1px solid #000; height:4mm; width:50%; margin:2px auto;"></div>
                @endif
                <br>
                <strong>LUGAR Y FECHA:</strong><br>
                @if ($transferencia->entregado_fecha)
                    Tabio, {{ $transferencia->entregado_fecha->format('d/m/Y H:i') }}
                @endif
            </td>

            {{-- RECIBIDO POR --}}
            <td style="width:33.33%; vertical-align:top; text-align:center; padding:0 2px;">
                <strong>RECIBIDO POR:</strong><br>
                {{ $reci['nombre'] }}<br>
                <em>{{ $reci['dependencia'] }}</em><br>
                @if ($reci['firma_path'])
                    <img src="{{ $reci['firma_path'] }}"
                        style="
              width:90mm;
              height:auto;
              object-fit:contain;
              display:block;
              margin:2px auto;
            "
                        alt="Firma Recibido">
                @else
                    <div style="border-bottom:1px solid #000; height:4mm; width:50%; margin:2px auto;"></div>
                @endif
                <br>
                <strong>LUGAR Y FECHA:</strong><br>
                @if ($transferencia->recibido_fecha)
                    Tabio, {{ $transferencia->recibido_fecha->format('d/m/Y H:i') }}
                @endif
            </td>
        </tr>
    </table>
</div>
