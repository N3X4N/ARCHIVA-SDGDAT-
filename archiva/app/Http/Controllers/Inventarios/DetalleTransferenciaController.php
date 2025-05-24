<?php

namespace App\Http\Controllers\Inventarios;

use App\Http\Controllers\Controller;
use App\Models\DetallesTransferenciaDocumental;
use App\Models\TransferenciaDocumental;
use Illuminate\Http\Request;

class DetalleTransferenciaController extends Controller
{
    /**
     * Permite crear detalles adicionales sin tocar cabecera.
     */
    public function store(Request $request, TransferenciaDocumental $transferencia)
    {
        // similar a lo que hacemos en store/update de TransferenciaDocumentalController
        // pero aquí recibirías sólo 1 fila a la vez si lo deseas
        $data = $request->validate([
            'serie_documental_id'    => 'required|exists:series_documentales,id',
            'subserie_documental_id' => 'nullable|exists:subseries_documentales,id',
            'ubicacion_id'           => 'nullable|exists:ubicaciones,id',
            'soporte_id'             => 'nullable|exists:soportes,id',
            'numero_orden'           => 'nullable|string',
            'codigo'                 => 'nullable|string',
            'fecha_inicial'          => 'nullable|date',
            'fecha_final'            => 'nullable|date|after_or_equal:fecha_inicial',
            'caja'                   => 'nullable|integer',
            'carpeta'                => 'nullable|integer',
            'resolucion'             => 'nullable|integer',
            'tomo'                   => 'nullable|integer',
            'otro'                   => 'nullable|string',
            'numero_folios'          => 'nullable|integer',
            'frecuencia_consulta'    => 'nullable|string',
            'observaciones'          => 'nullable|string',
            'estado_flujo'           => 'nullable|string',
        ]);

        $transferencia->detalles()->create($data);

        return back()->with('success','Detalle agregado');
    }

    /**
     * Soft‐delete de un detalle individual.
     */
    public function destroy(DetallesTransferenciaDocumental $detalle)
    {
        $detalle->delete();
        return back()->with('success','Detalle eliminado');
    }
}
