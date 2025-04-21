<?php

namespace App\Http\Controllers\Inventarios;

use App\Http\Controllers\Controller;
use App\Models\TransferenciaDocumental;
use Illuminate\Http\Request;

use App\Models\Dependencia;
use App\Models\SerieDocumental;
use App\Models\SubserieDocumental;
use App\Models\Ubicacion;
use App\Models\Soporte;

class TransferenciaDocumentalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Usar paginación, por ejemplo, 10 registros por página
        $transferencias = TransferenciaDocumental::paginate(10);

        // Devuelve la vista con las transferencias
        return view('inventarios.transferencias.index', compact('transferencias'));
    }

    public function create()
    {
        // Pasa los datos necesarios a la vista para mostrar el formulario de creación
        return view('inventarios.transferencias.create', [
            'dependencias' => Dependencia::active()->pluck('nombre', 'id'),
            'series' => SerieDocumental::active()->pluck('nombre', 'id'),
            'subseries' => SubserieDocumental::active()->pluck('nombre', 'id'),
            'ubicaciones' => Ubicacion::active()->pluck('nombre', 'id'),
            'soportes' => Soporte::active()->pluck('nombre', 'id'),
        ]);
    }

    public function edit(TransferenciaDocumental $transferenciaDocumental)
    {
        return view('inventarios.transferencias.edit', [
            'transferencia' => $transferenciaDocumental,
            'dependencias'  => Dependencia::active()->pluck('nombre', 'id'),
            'series'        => SerieDocumental::active()->pluck('nombre', 'id'),
            'subseries'     => SubserieDocumental::active()->pluck('nombre', 'id'),
            'ubicaciones'   => Ubicacion::active()->pluck('nombre', 'id'),
            'soportes'      => Soporte::active()->pluck('nombre', 'id'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TransferenciaDocumental  $transferenciaDocumental
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TransferenciaDocumental $transferencia)
    {
        $data = $request->validate([
            'dependencia_id'          => 'required|exists:dependencias,id',
            'serie_documental_id'     => 'required|exists:series_documentales,id',
            'subserie_documental_id'  => 'nullable|exists:subseries_documentales,id',
            'ubicacion_id'            => 'required|exists:ubicaciones,id',
            'soporte_id'              => 'required|exists:soportes,id',
            'registro_entrada'        => 'nullable|date',
            'codigo_interno'          => 'required|string|max:50|unique:transferencias_documentales,codigo_interno,' . $transferencia->id,
            'objeto'                  => 'nullable|string',
            'fecha_extrema_inicial'   => 'nullable|date',
            'fecha_extrema_final'     => 'nullable|date|after_or_equal:fecha_extrema_inicial',
            'numero_folios'           => 'nullable|integer|min:0',
            'observaciones'           => 'nullable|string',
        ]);

        $transferencia->update($data);

        return redirect()
            ->route('inventarios.transferencias.index')
            ->with('success', 'Transferencia actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TransferenciaDocumental  $transferenciaDocumental
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransferenciaDocumental $transferenciaDocumental)
    {
        $transferenciaDocumental->delete();

        return redirect()
            ->route('inventarios.transferencias.index')
            ->with('success', 'Transferencia eliminada correctamente.');
    }
}
