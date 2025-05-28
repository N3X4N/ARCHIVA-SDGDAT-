{{-- resources/views/inventarios/transferencias/pdf_all.blade.php --}}

@php
    // Carga el logo una sola vez
    $path = public_path('assets/Imagen1.png');
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $logoData = base64_encode(file_get_contents($path));

    /**
     * Función helper para extraer datos de firma
     */
    function firmaData($userRelation)
    {
        $user = optional($userRelation);
        $perfil = optional($user->perfil);
        $depend = optional($perfil->dependencia)->nombre;
        $firma = $perfil->firma_digital;
        $ruta = $firma ? storage_path("app/public/{$firma}") : null;

        return [
            'nombre' => trim(($perfil->nombres ?? '') . ' ' . ($perfil->apellidos ?? '')),
            'dependencia' => $depend,
            'firma_path' => $ruta && file_exists($ruta) ? $ruta : null,
        ];
    }
@endphp

<style>
    .pagenum:before {
        content: counter(page);
    }

    .pagecount:before {
        content: counter(pages);
    }
</style>

@foreach ($transferencias as $i => $transferencia)
    @php
        // Prepara datos de firma para ésta transferencia
        $elab = firmaData($transferencia->elaboradoBy);
        $entg = firmaData($transferencia->entregadoBy);
        $reci = firmaData($transferencia->recibidoBy);
    @endphp

    {{-- --------- Cabecera --------- --}}
    <table style="width:100%; border:1px solid #000; border-collapse: collapse; margin-bottom:2mm;">
        <tr>
            <td rowspan="2"
                style="width:15%;border:1px solid #000;text-align:center;vertical-align:middle;padding:2px">
                <img src="data:image/{{ $type }};base64,{{ $logoData }}"
                    style="width:80px;margin:0 auto;display:block" alt="Logo">
                <div style="font-size:7pt;margin-top:1mm">Alcaldía Municipal de Tabio</div>
            </td>
            <td colspan="2" style="border:1px solid #000;text-align:center;vertical-align:middle;padding:2px">
                <div style="font-size:11pt;font-weight:bold;line-height:1.1">Proceso Gestión Documental y Archivo</div>
            </td>
            <td rowspan="2" style="width:15%;border:1px solid #000;vertical-align:top;padding:0">
                <table style="width:100%;border:none;border-collapse:collapse;font-size:7pt">
                    <tr>
                        <th style="border:none;padding:2px;text-align:left">Código:</th>
                        <td style="border:none;padding:2px">260-GDA-F-1</td>
                    </tr>
                    <tr>
                        <th style="border:none;padding:2px;text-align:left">Versión:</th>
                        <td style="border:none;padding:2px">3.0</td>
                    </tr>
                    <tr>
                        <th style="border:none;padding:2px;text-align:left">Fecha:</th>
                        <td style="border:none;padding:2px">{{ now()->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th style="border:none; padding:2px; text-align:left;">Página:</th>
                        <td style="border:none; padding:2px;">
                            <span class="pagenum"></span> de <span class="pagecount"></span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="border:1px solid #000;text-align:center;vertical-align:middle;padding:2px">
                <div style="font-size:10pt;font-weight:bold;line-height:1.1">Formato único de inventario documental
                </div>
            </td>
        </tr>
    </table>

    {{-- --------- Información general --------- --}}
    <table style="width:100%;border:1px solid #000;border-collapse:collapse;margin-top:2mm;font-size:7pt">
        <tr>
            <th style="width:15%;border:1px solid #000;padding:3px;text-align:left">ENTIDAD REMITENTE:</th>
            <td style="width:20%;border:1px solid #000;padding:3px">{{ $transferencia->entidadRemitente->nombre }}</td>
            <th style="width:15%;border:1px solid #000;padding:3px;text-align:left">ENTIDAD PRODUCTORA:</th>
            <td style="width:20%;border:1px solid #000;padding:3px">{{ $transferencia->entidadProductora->nombre }}</td>
            <th colspan="4" style="border:1px solid #000;padding:3px;text-align:center">REGISTRO DE ENTRADA</th>
        </tr>
        <tr>
            <th style="border:1px solid #000;padding:3px;text-align:left">UNIDAD ADMINISTRATIVA:</th>
            <td style="border:1px solid #000;padding:3px">{{ $transferencia->unidad_administrativa }}</td>
            <th style="border:1px solid #000;padding:3px;text-align:left">OFICINA PRODUCTORA:</th>
            <td style="border:1px solid #000;padding:3px">{{ $transferencia->oficinaProductora->nombre }}</td>
            <th style="width:7%;border:1px solid #000;padding:3px;text-align:center">AÑO</th>
            <th style="width:7%;border:1px solid #000;padding:3px;text-align:center">MES</th>
            <th style="width:7%;border:1px solid #000;padding:3px;text-align:center">DÍA</th>
            <th style="width:9%;border:1px solid #000;padding:3px;text-align:center">N° T</th>
        </tr>
        <tr>
            <th colspan="4" rowspan="2"
                style="border:1px solid #000;padding:3px;padding-top:2px;text-align:left;vertical-align:top">
                OBJETO: {{ $transferencia->objeto }}
            </th>
            <td style="border:1px solid #000;padding:3px;text-align:center">
                {{ $transferencia->registro_entrada->format('Y') }}</td>
            <td style="border:1px solid #000;padding:3px;text-align:center">
                {{ $transferencia->registro_entrada->format('m') }}</td>
            <td style="border:1px solid #000;padding:3px;text-align:center">
                {{ $transferencia->registro_entrada->format('d') }}</td>
            <td style="border:1px solid #000;padding:3px;text-align:center">{{ $transferencia->numero_transferencia }}
            </td>
        </tr>
        <tr>
            <td colspan="4" style="border:1px solid #000;padding:3px;text-align:left;font-size:7pt">
                Número de Transferencia: {{ $transferencia->numero_transferencia }}
            </td>
        </tr>
    </table>

    {{-- --------- Detalles --------- --}}
    <table style="width:100%;border:1px solid #000;border-collapse:collapse;margin-top:2mm;font-size:7pt">
        <thead>
            <tr>
                <th rowspan="2" style="border:1px solid #000;padding:3px;text-align:center">N° ORDEN</th>
                <th rowspan="2" style="border:1px solid #000;padding:3px;text-align:center">CÓDIGO</th>
                <th rowspan="2" style="border:1px solid #000;padding:3px;text-align:center;width:20%">NOMBRE DE LAS
                    SERIES…</th>
                <th colspan="2" style="border:1px solid #000;padding:3px;text-align:center">FECHAS EXTREMAS</th>
                <th colspan="4" style="border:1px solid #000;padding:3px;text-align:center">UNIDAD DE CONSERVACIÓN
                </th>
                <th rowspan="2" style="border:1px solid #000;padding:3px;text-align:center">N° FOLIOS</th>
                <th rowspan="2" style="border:1px solid #000;padding:3px;text-align:center">SOPORTE</th>
                <th rowspan="2" style="border:1px solid #000;padding:3px;text-align:center">FREC. CONSULTA</th>
                <th colspan="3" style="border:1px solid #000;padding:3px;text-align:center">UBICACIÓN</th>
                <th rowspan="2" style="border:1px solid #000;padding:3px;text-align:center">OBSERVACIONES</th>
            </tr>
            <tr>
                <th style="border:1px solid #000;padding:3px;text-align:center">INICIAL</th>
                <th style="border:1px solid #000;padding:3px;text-align:center">FINAL</th>
                <th style="border:1px solid #000;padding:3px;text-align:center">CAJA</th>
                <th style="border:1px solid #000;padding:3px;text-align:center">CARPETA</th>
                <th style="border:1px solid #000;padding:3px;text-align:center">TOMO</th>
                <th style="border:1px solid #000;padding:3px;text-align:center">OTRO</th>
                <th style="border:1px solid #000;padding:3px;text-align:center">CAJA</th>
                <th style="border:1px solid #000;padding:3px;text-align:center">BANDEJA</th>
                <th style="border:1px solid #000;padding:3px;text-align:center">ESTANTE</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transferencia->detalles as $detalle)
                <tr>
                    <td style="border:1px solid #000;padding:3px">{{ $detalle->numero_orden }}</td>
                    <td style="border:1px solid #000;padding:3px">{{ $detalle->codigo }}</td>
                    <td style="border:1px solid #000;padding:3px;text-align:left">
                        @if ($detalle->subserie)
                            {{ $detalle->subserie->nombre }}
                        @elseif($detalle->serie)
                            <strong>{{ $detalle->serie->nombre }}</strong>
                        @else
                            –
                        @endif
                    </td>
                    <td style="border:1px solid #000;padding:3px;text-align:center">{{ $detalle->fecha_inicial }}</td>
                    <td style="border:1px solid #000;padding:3px;text-align:center">{{ $detalle->fecha_final }}</td>
                    <td style="border:1px solid #000;padding:3px;text-align:center">{{ $detalle->caja }}</td>
                    <td style="border:1px solid #000;padding:3px;text-align:center">{{ $detalle->carpeta }}</td>
                    <td style="border:1px solid #000;padding:3px;text-align:center">{{ $detalle->tomo }}</td>
                    <td style="border:1px solid #000;padding:3px;text-align:center">{{ $detalle->otro }}</td>
                    <td style="border:1px solid #000;padding:3px;text-align:center">{{ $detalle->numero_folios }}</td>
                    <td style="border:1px solid #000;padding:3px">{{ optional($detalle->soporte)->nombre }}</td>
                    <td style="border:1px solid #000;padding:3px">{{ $detalle->frecuencia_consulta }}</td>
                    <td style="border:1px solid #000;padding:3px;text-align:center">
                        {{ optional($detalle->ubicacion)->caja }}</td>
                    <td style="border:1px solid #000;padding:3px;text-align:center">
                        {{ optional($detalle->ubicacion)->bandeja }}</td>
                    <td style="border:1px solid #000;padding:3px;text-align:center">
                        {{ optional($detalle->ubicacion)->estante }}</td>
                    <td style="border:1px solid #000;padding:3px;text-align:left">{{ $detalle->observaciones }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- --------- Firmas --------- --}}
    <div style="page-break-inside: avoid; margin-top:4mm; text-align:center; font-size:7pt">
        <table style="width:100%;border-collapse:collapse">
            <tr>
                {{-- Elaborado --}}
                <td style="width:33.33%;padding:0 2px;vertical-align:top">
                    <strong>ELABORADO POR:</strong><br>
                    {{ $elab['nombre'] }}<br>
                    <em>{{ $elab['dependencia'] }}</em><br>
                    @if ($elab['firma_path'])
                        <img src="{{ $elab['firma_path'] }}"
                            style="width:40mm;max-height:15mm;object-fit:contain;margin:2px auto;display:block">
                    @else
                        <div style="border-bottom:1px solid #000;height:5mm;width:50%;margin:2px auto"></div>
                    @endif
                    <br><strong>LUGAR Y FECHA:</strong><br>
                    @if ($transferencia->elaborado_fecha)
                        Tabio, {{ $transferencia->elaborado_fecha->format('d/m/Y H:i') }}
                    @endif
                </td>
                {{-- Entregado --}}
                <td style="width:33.33%;padding:0 2px;vertical-align:top">
                    <strong>ENTREGADO POR:</strong><br>
                    {{ $entg['nombre'] }}<br>
                    <em>{{ $entg['dependencia'] }}</em><br>
                    @if ($entg['firma_path'])
                        <img src="{{ $entg['firma_path'] }}"
                            style="width:40mm;max-height:15mm;object-fit:contain;margin:2px auto;display:block">
                    @else
                        <div style="border-bottom:1px solid #000;height:5mm;width:50%;margin:2px auto"></div>
                    @endif
                    <br><strong>LUGAR Y FECHA:</strong><br>
                    @if ($transferencia->entregado_fecha)
                        Tabio, {{ $transferencia->entregado_fecha->format('d/m/Y H:i') }}
                    @endif
                </td>
                {{-- Recibido --}}
                <td style="width:33.33%;padding:0 2px;vertical-align:top">
                    <strong>RECIBIDO POR:</strong><br>
                    {{ $reci['nombre'] }}<br>
                    <em>{{ $reci['dependencia'] }}</em><br>
                    @if ($reci['firma_path'])
                        <img src="{{ $reci['firma_path'] }}"
                            style="width:40mm;max-height:15mm;object-fit:contain;margin:2px auto;display:block">
                    @else
                        <div style="border-bottom:1px solid #000;height:5mm;width:50%;margin:2px auto"></div>
                    @endif
                    <br><strong>LUGAR Y FECHA:</strong><br>
                    @if ($transferencia->recibido_fecha)
                        Tabio, {{ $transferencia->recibido_fecha->format('d/m/Y H:i') }}
                    @endif
                </td>
            </tr>
        </table>
    </div>

    @if ($i < $transferencias->count() - 1)
        <div style="page-break-after: always;"></div>
    @endif
@endforeach

{{-- Para que DOMPDF imprima números de página --}}
<script type="text/php">
    if (isset($pdf)) {
        $font = $fontMetrics->getFont("Helvetica", "normal");
        // por ejemplo, y = 20mm desde arriba
        $pdf->page_text(450, 20, "Página {PAGE_NUM} de {PAGE_COUNT}", $font, 7, [0,0,0]);
    }
</script>
