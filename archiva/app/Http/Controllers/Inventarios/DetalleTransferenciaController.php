<?php

namespace App\Http\Controllers;

use App\Models\DetallesTransferenciaDocumental;
use App\Models\TransferenciaDocumental;
use Illuminate\Http\Request;

class DetalleTransferenciaController extends Controller
{
    public function store(Request $request, TransferenciaDocumental $transferencia)
    {
        $request->validate([
            'numero_orden' => 'required',
            'codigo' => 'required',
            'nombre_series_subserie' => 'required',
            'fecha_inicial' => 'required|date',
            'fecha_final' => 'required|date',
            'caja' => 'required|integer',
            'carpeta' => 'required|integer',
            'resolucion' => 'required|integer',
            'otro' => 'required',
            'numero_folios' => 'required|integer',
            'soporte' => 'required',
            'frecuencia_consulta' => 'required',
            'ubicacion_caja' => 'required',
            'ubicacion_bandeja' => 'required',
            'ubicacion_estante' => 'required',
            'observaciones' => 'required',
            'estado_flujo' => 'required',
        ]);

        $transferencia->detalles()->create($request->all());

        return redirect()->route('inventarios.transferencias.index')->with('success', 'Detalle de Transferencia Documental agregado con éxito');
    }

    // Delete a Detalle
    public function destroy(DetallesTransferenciaDocumental $detalle)
    {
        $detalle->delete();

        return redirect()->route('inventarios.transferencias.index')->with('success', 'Detalle de Transferencia Documental eliminado con éxito');
    }
}
