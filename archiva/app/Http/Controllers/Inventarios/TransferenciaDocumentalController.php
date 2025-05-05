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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $dependencia_id = $request->get('dependencia_id');
        $serie_documental_id = $request->get('serie_documental_id');
        $subserie_documental_id = $request->get('subserie_documental_id');
        $estado_flujo = $request->get('estado_flujo');
        $codigo_interno = $request->get('codigo_interno');
        $ubicacion_id = $request->get('ubicacion_id');
        $soporte_id = $request->get('soporte_id');
        $fecha_inicio = $request->get('fecha_inicio');
        $fecha_fin = $request->get('fecha_fin');

        $query = TransferenciaDocumental::query();

        if ($dependencia_id) {
            $query->where('dependencia_id', $dependencia_id);
        }

        if ($serie_documental_id) {
            $query->where('serie_documental_id', $serie_documental_id);
        }

        if ($subserie_documental_id) {
            $query->where('subserie_documental_id', $subserie_documental_id);
        }

        if ($estado_flujo) {
            $query->where('estado_flujo', $estado_flujo);
        }

        if ($codigo_interno) {
            $query->where('codigo_interno', 'like', "%$codigo_interno%");
        }

        if ($ubicacion_id) {
            $query->where('ubicacion_id', $ubicacion_id);
        }

        if ($soporte_id) {
            $query->where('soporte_id', $soporte_id);
        }

        if ($fecha_inicio && $fecha_fin) {
            $query->whereBetween('registro_entrada', [$fecha_inicio, $fecha_fin]);
        }

        $transferencias = $query->with('detalles')->paginate(10);

        $dependencias = Dependencia::active()->pluck('nombre', 'id');
        $series = SerieDocumental::active()->pluck('nombre', 'id');
        $subseries = SubserieDocumental::active()->pluck('nombre', 'id');
        $ubicaciones = Ubicacion::active()->pluck('estante', 'id');
        $soportes = Soporte::active()->pluck('nombre', 'id');

        return view('inventarios.transferencias.index', compact('transferencias', 'dependencias', 'series', 'subseries', 'ubicaciones', 'soportes'));
    }


    public function create()
    {
        $transferencia = new TransferenciaDocumental();

        // Obtener el último número de transferencia registrado
        $lastTransfer = TransferenciaDocumental::latest()->first();
        $lastTransferNumber = (int) ($lastTransfer->numero_transferencia ?? 0);  // Convierte a entero
        $nextTransferNumber = $lastTransferNumber + 1;  // Sumar 1 al número de transferencia


        return view('inventarios.transferencias.create', [
            'dependencias' => Dependencia::active()->pluck('nombre', 'id'),
            'series' => SerieDocumental::active()->pluck('nombre', 'id'),
            'subseries' => SubserieDocumental::active()->pluck('nombre', 'id'),
            'ubicaciones' => Ubicacion::active()->pluck('estante', 'id'),
            'soportes' => Soporte::active()->pluck('nombre', 'id'),
            'transferencia' => $transferencia,  // Asegúrate de pasar el objeto transferencia vacío
            'nextTransferNumber' => $nextTransferNumber,  // Pasamos el siguiente número de transferencia
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'dependencia_id' => 'required',
            'entidad_productora' => 'required',
            'unidad_administrativa' => 'required',
            'oficina_productora' => 'required',
            'numero_transferencia' => 'required',
            'objeto' => 'required',
        ]);

        TransferenciaDocumental::create($request->all());

        return redirect()->route('inventarios.transferencias.index')->with('success', 'Transferencia Documental creada con éxito');
    }

    // Update an existing Transferencia Documental
    public function update(Request $request, TransferenciaDocumental $transferencia)
    {
        $request->validate([
            'dependencia_id' => 'required',
            'entidad_productora' => 'required',
            'unidad_administrativa' => 'required',
            'oficina_productora' => 'required',
            'numero_transferencia' => 'required',
            'objeto' => 'required',
        ]);

        $transferencia->update($request->all());

        return redirect()->route('inventarios.transferencias.index')->with('success', 'Transferencia Documental actualizada con éxito');
    }

    // Delete Transferencia Documental
    public function destroy(TransferenciaDocumental $transferencia)
    {
        $transferencia->delete();

        return redirect()->route('inventarios.transferencias.index')->with('success', 'Transferencia Documental eliminada con éxito');
    }
}
