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
    public function index(Request $request)
    {
        // Cargamos transferencia + detalles + serie + subserie + dependencia
        $query = TransferenciaDocumental::with([
            'detalles.serie',
            'detalles.subserie',
            'dependencia',
        ]);

        // …tus filtros existentes…
        if ($request->filled('dependencia_id')) {
            $query->where('dependencia_id', $request->dependencia_id);
        }
        if ($request->filled('estado_flujo')) {
            $query->where('estado_flujo', $request->estado_flujo);
        }
        if ($request->filled('fecha_inicio')) {
            $query->where('registro_entrada', '>=', $request->fecha_inicio);
        }
        if ($request->filled('fecha_fin')) {
            $query->where('registro_entrada', '<=', $request->fecha_fin);
        }

        $transferencias = $query->latest()->paginate(10);

        $dependencias = Dependencia::active()->pluck('nombre', 'id');
        $estados      = ['ELABORADO' => 'Elaborado', 'ARCHIVADO' => 'Archivado'];

        return view('inventarios.transferencias.index', compact(
            'transferencias',
            'dependencias',
            'estados'
        ));
    }

    public function create()
{
    $nextTransferNumber = (int) (TransferenciaDocumental::max('numero_transferencia') ?? 0) + 1;

    // Para los selects
    $dependencias           = Dependencia::active()->pluck('nombre', 'id');
    $entidadesProductoras   = Dependencia::active()->pluck('nombre', 'id'); // o ajusta si vienen de otro modelo
    $oficinasProductoras    = Dependencia::active()->pluck('nombre', 'id'); // idem
    $ubicaciones            = Ubicacion::active()->pluck('estante', 'id');

    // Series / subseries...
    $seriesList    = SerieDocumental::where('is_active', true)->pluck('nombre', 'id');
    $seriesCodes   = SerieDocumental::where('is_active', true)->pluck('codigo', 'id')->toArray();
    $subseriesGroup = SubserieDocumental::where('is_active', true)
        ->get()
        ->groupBy('serie_documental_id')
        ->map(fn($col) => $col->pluck('nombre','id')->toArray())
        ->toArray();
    $subseriesCodes = SubserieDocumental::where('is_active', true)
        ->pluck('codigo', 'id')
        ->toArray();

    return view('inventarios.transferencias.create', compact(
        'dependencias',
        'entidadesProductoras',
        'oficinasProductoras',
        'ubicaciones',
        'nextTransferNumber',
        'seriesList',
        'seriesCodes',
        'subseriesGroup',
        'subseriesCodes'
    ));
}

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
        $transferencia->load(['detalles.serie', 'detalles.subserie']);

        $seriesList   = SerieDocumental::where('is_active', true)->pluck('nombre', 'id');
        $seriesCodes  = SerieDocumental::where('is_active', true)->pluck('codigo', 'id')->toArray();

        $subseriesList  = SubserieDocumental::where('is_active', true)
            ->get()
            ->groupBy('serie_documental_id')
            ->map(fn($col) => $col->pluck('nombre', 'id')->toArray())
            ->toArray();
        $subseriesCodes = SubserieDocumental::where('is_active', true)
            ->pluck('codigo', 'id')
            ->toArray();

        return view('inventarios.transferencias.edit', compact(
            'transferencia',
            'dependencias',
            'ubicaciones',
            'nextTransferNumber',
            'seriesList',
            'seriesCodes',
            'subseriesList',
            'subseriesCodes'
        ));
    }


    /* ===== ELIMINAR (soft delete) ===== */
    public function destroy(TransferenciaDocumental $transferencia)
    {
        $transferencia->delete();
        return back()->with('success', 'Transferencia eliminada');
    }
}
