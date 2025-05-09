<?php

namespace App\Http\Controllers\Inventarios;

use App\Http\Controllers\Controller;
use App\Models\TransferenciaDocumental;
use App\Models\DetallesTransferenciaDocumental;
use App\Models\Dependencia;
use App\Models\SerieDocumental;
use App\Models\SubserieDocumental;
use App\Models\Ubicacion;
use App\Models\Soporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransferenciaDocumentalController extends Controller
{
    /* ===== LISTADO ===== */
    public function index(Request $request)
    {
        $query = TransferenciaDocumental::query();

        // Filtro por Dependencia
        if ($request->filled('dependencia_id')) {
            $query->where('dependencia_id', $request->dependencia_id);
        }

        // Filtro por Estado
        if ($request->filled('estado_flujo')) {
            $query->where('estado_flujo', $request->estado_flujo);
        }

        // Filtro por Fecha de Registro
        if ($request->filled('fecha_inicio')) {
            $query->where('registro_entrada', '>=', $request->fecha_inicio);
        }

        if ($request->filled('fecha_fin')) {
            $query->where('registro_entrada', '<=', $request->fecha_fin);
        }

        // Obtener las transferencias con paginación
        $transferencias = $query->latest()->paginate(10);  // Puedes cambiar el número de páginas según lo necesites

        // Cargar los datos para los filtros
        $dependencias = Dependencia::active()->pluck('nombre', 'id');
        $estados = ['ELABORADO' => 'Elaborado', 'ARCHIVADO' => 'Archivado']; // Ejemplo de estados

        // Devolver la vista con los datos
        return view('inventarios.transferencias.index', [
            'transferencias' => $transferencias,
            'dependencias' => $dependencias,
            'estados' => $estados,
        ]);
    }

    /* ===== FORMULARIO CREAR ===== */
    public function create()
    {
        $nextTransferNumber = (int) (TransferenciaDocumental::max('numero_transferencia') ?? 0) + 1;

        return view('inventarios.transferencias.create', [
            'dependencias'        => Dependencia::active()->pluck('nombre', 'id'),
            'ubicaciones'         => Ubicacion::active()->pluck('estante', 'id'),
            'nextTransferNumber'  => $nextTransferNumber,
        ]);
    }

    /* ===== GUARDAR ===== */
    public function store(Request $request)
    {
        $request->validate([
            'dependencia_id'        => 'required|exists:dependencias,id',
            'ubicacion_id'          => 'required|exists:ubicaciones,id',
            'entidad_productora'    => 'required|string',
            'unidad_administrativa' => 'required|string',
            'oficina_productora'    => 'required|string',
            'numero_transferencia'  => 'required|string|unique:transferencias_documentales,numero_transferencia',
            'objeto'                => 'nullable|string',

            // Detalles (arrays)
            'numero_orden.*'            => 'required',
            'nombre_series_subserie.*'  => 'required|string',
            'fecha_inicial.*'           => 'nullable|date',
            'fecha_final.*'             => 'nullable|date',
        ]);

        DB::transaction(function () use ($request) {

            /* --- 1. cabecera --- */
            $transferencia = TransferenciaDocumental::create([
                'user_id'              => auth()->id(),
                'dependencia_id'       => $request->dependencia_id,
                'ubicacion_id'         => $request->ubicacion_id,
                'entidad_productora'   => $request->entidad_productora,
                'unidad_administrativa' => $request->unidad_administrativa,
                'oficina_productora'   => $request->oficina_productora,
                'registro_entrada'     => now(),
                'numero_transferencia' => $request->numero_transferencia,
                'objeto'               => $request->objeto,
            ]);

            /* --- 2. detalles --- */
            foreach ($request->input('numero_orden', []) as $i => $orden) {
                $transferencia->detalles()->create([
                    'ubicacion_id'           => $request->ubicacion_id,
                    'numero_orden'           => $orden,
                    'codigo'                 => $request->codigo[$i]                 ?? null,
                    'nombre_series_subserie' => $request->nombre_series_subserie[$i] ?? null,
                    'fecha_inicial'          => $request->fecha_inicial[$i]          ?? null,
                    'fecha_final'            => $request->fecha_final[$i]            ?? null,
                    'caja'                   => $request->caja[$i]                   ?? null,
                    'carpeta'                => $request->carpeta[$i]                ?? null,
                    'resolucion'             => $request->resolucion[$i]             ?? null,
                    'tomo'                   => $request->tomo[$i]                   ?? null,
                    'otro'                   => $request->otro[$i]                   ?? null,
                    'numero_folios'          => $request->numero_folios[$i]          ?? null,
                    'soporte'                => $request->soporte[$i]                ?? null,
                    'frecuencia_consulta'    => $request->frecuencia_consulta[$i]    ?? null,
                    'ubicacion_caja'         => $request->ubicacion_caja[$i]         ?? null,
                    'ubicacion_bandeja'      => $request->ubicacion_bandeja[$i]      ?? null,
                    'ubicacion_estante'      => $request->ubicacion_estante[$i]      ?? null,
                    'observaciones'          => $request->observaciones[$i]          ?? null,
                ]);
            }
        });

        return redirect()
            ->route('inventarios.transferencias.index')
            ->with('success', 'Transferencia creada con sus detalles');
    }

    /* ===== ACTUALIZAR CABECERA (sin detalles) ===== */
    public function update(Request $request, TransferenciaDocumental $transferencia)
    {
        $request->validate([
            'dependencia_id'        => 'required|exists:dependencias,id',
            'ubicacion_id'          => 'required|exists:ubicaciones,id',
            'entidad_productora'    => 'required',
            'unidad_administrativa' => 'required',
            'oficina_productora'    => 'required',
            'objeto'                => 'nullable|string',
        ]);

        $transferencia->update($request->only([
            'dependencia_id',
            'ubicacion_id',
            'entidad_productora',
            'unidad_administrativa',
            'oficina_productora',
            'objeto',
        ]));

        return back()->with('success', 'Transferencia actualizada');
    }

    public function edit(TransferenciaDocumental $transferencia)
    {
        // cargamos detalles para pintarlos
        $transferencia->load('detalles');   // Eager‑load

        return view('inventarios.transferencias.edit', [
            'transferencia'   => $transferencia,
            'dependencias'    => Dependencia::active()->pluck('nombre', 'id'),
            'ubicaciones'     => Ubicacion::active()->pluck('estante', 'id'),
            'nextTransferNumber' => $transferencia->numero_transferencia, // ya existe
        ]);
    }


    /* ===== ELIMINAR (soft delete) ===== */
    public function destroy(TransferenciaDocumental $transferencia)
    {
        $transferencia->delete();
        return back()->with('success', 'Transferencia eliminada');
    }
}
