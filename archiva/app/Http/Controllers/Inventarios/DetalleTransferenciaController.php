<?php

namespace App\Http\Controllers;

use App\Models\DetallesTransferenciaDocumental;
use App\Models\TransferenciaDocumental;
use App\Models\SerieDocumental;
use App\Models\SubserieDocumental;
use Illuminate\Http\Request;

class DetalleTransferenciaController extends Controller
{
    public function store(Request $request, TransferenciaDocumental $transferencia)
    {
        $data = $request->validate([
            'serie_documental_id'    => 'required|exists:series_documentales,id',
            'subserie_documental_id' => 'nullable|exists:subseries_documentales,id',
            'ubicacion_id'           => 'nullable|exists:ubicaciones,id',
            'numero_orden'           => 'required|string',
            'fecha_inicial'          => 'required|date',
            'fecha_final'            => 'required|date|after_or_equal:fecha_inicial',
            'caja'                   => 'required|integer',
            'carpeta'                => 'required|integer',
            'resolucion'             => 'required|integer',
            'tomo'                   => 'nullable|integer',
            'otro'                   => 'nullable|string',
            'numero_folios'          => 'required|integer',
            'soporte'                => 'required|string',
            'frecuencia_consulta'    => 'required|string',
            'ubicacion_caja'         => 'required|string',
            'ubicacion_bandeja'      => 'required|string',
            'ubicacion_estante'      => 'required|string',
            'observaciones'          => 'nullable|string',
            'estado_flujo'           => 'required|string',
        ]);

        $depCode = $transferencia->dependencia->codigo;
        $count   = count($data['serie_documental_id']);

        // 2) Bucle: una fila = un detalle
        for ($i = 0; $i < $count; $i++) {
            $serieId = $data['serie_documental_id'][$i];
            $subId   = $data['subserie_documental_id'][$i] ?? null;

            $serie   = SerieDocumental::findOrFail($serieId);
            $sub     = $subId ? SubserieDocumental::findOrFail($subId) : null;

            // Código compuesto
            $serieCode = $serie->codigo;
            $subCode   = $sub?->codigo ?? '00';
            $codigo    = "{$depCode}.{$serieCode}.{$subCode}";

            // Nombre legible
            $nombre = $sub
                ? "{$serie->nombre} / {$sub->nombre}"
                : $serie->nombre;

            // Array de datos por fila
            $detalle = [
                'serie_documental_id'    => $serieId,
                'subserie_documental_id' => $subId,
                'ubicacion_id'           => $data['ubicacion_id'][$i] ?? null,
                'numero_orden'           => $data['numero_orden'][$i],
                'fecha_inicial'          => $data['fecha_inicial'][$i],
                'fecha_final'            => $data['fecha_final'][$i],
                'caja'                   => $data['caja'][$i] ?? null,
                // … completa con carpeta, resolución, tomo, otro, folios, soporte…
                'observaciones'          => $data['observaciones'][$i] ?? null,
                'estado_flujo'           => $data['estado_flujo'][$i] ?? 'Activo',

                'codigo'                 => $codigo,
                'nombre_series_subserie' => $nombre,
            ];

            // Crea el detalle (transferencia_id se añade automáticamente)
            $transferencia->detalles()->create($detalle);
        }

        return redirect()
            ->route('inventarios.transferencias.index')
            ->with('success', 'Detalle(s) agregado(s) con éxito');
    }

    // Delete a Detalle
    public function destroy(DetallesTransferenciaDocumental $detalle)
    {
        $detalle->delete();

        return redirect()->route('inventarios.transferencias.index')->with('success', 'Detalle de Transferencia Documental eliminado con éxito');
    }
}
