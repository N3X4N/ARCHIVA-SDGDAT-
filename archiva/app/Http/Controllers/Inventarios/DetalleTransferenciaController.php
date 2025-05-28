<?php

namespace App\Http\Controllers\Inventarios;

use App\Http\Controllers\Controller;
use App\Models\DetallesTransferenciaDocumental;
use App\Models\TransferenciaDocumental;
use App\Models\SerieDocumental;
use App\Models\SubserieDocumental;
use App\Models\Dependencia;
use App\Models\Ubicacion;
use Illuminate\Http\Request;

class DetalleTransferenciaController extends Controller
{

    public function index(Request $request)
    {
        $query = DetallesTransferenciaDocumental::with([
            'transferencia.entidadProductora',
            'transferencia',
            'serie',
            'subserie',
            'ubicacion',    // relación de ubicación
            'soporte',
        ])
            // 1) Ordenar por número de transferencia
            ->orderBy(
                TransferenciaDocumental::select('numero_transferencia')
                    ->whereColumn(
                        'transferencias_documentales.id',
                        'detalles_transferencias_documentales.transferencia_id'
                    ),
                'asc'
            )
            // 2) Luego por fecha inicial descendente
            ->orderBy('fecha_inicial', 'desc');

        // ——— FILTROS ———

        // Dependencia productora
        if ($request->filled('entidad_productora_id')) {
            $query->whereHas(
                'transferencia',
                fn($q) =>
                $q->where('entidad_productora_id', $request->entidad_productora_id)
            );
        }

        // Serie documental
        if ($request->filled('serie_id')) {
            $query->where('serie_documental_id', $request->serie_id);
        }

        // Subserie documental
        if ($request->filled('subserie_id')) {
            $query->where('subserie_documental_id', $request->subserie_id);
        }

        // Estado de flujo
        if ($request->filled('estado_flujo')) {
            $query->where('estado_flujo', $request->estado_flujo);
        }

        // Ubicación (detalle)
        if ($request->filled('ubicacion_id')) {
            $query->where('ubicacion_id', $request->ubicacion_id);
        }

        // Rango fecha inicial
        if ($request->filled('fecha_inicial_desde')) {
            $query->whereDate('fecha_inicial', '>=', $request->fecha_inicial_desde);
        }
        if ($request->filled('fecha_inicial_hasta')) {
            $query->whereDate('fecha_inicial', '<=', $request->fecha_inicial_hasta);
        }

        // Búsqueda libre en código, orden u observaciones
        if ($request->filled('busqueda')) {
            $bus = $request->busqueda;
            $query->where(
                fn($q) =>
                $q->where('codigo', 'like', "%{$bus}%")
                    ->orWhere('numero_orden', 'like', "%{$bus}%")
                    ->orWhere('observaciones', 'like', "%{$bus}%")
            );
        }

        // Sólo items con SUBSERIE asociada
        $query->whereNotNull('subserie_documental_id');

        $detalles = $query->paginate(20)->appends($request->query());

        // otros selects…
        $dependencias = Dependencia::pluck('nombre', 'id');
        $series       = SerieDocumental::whereHas('subseries')->pluck('nombre', 'id');
        $subseries    = SubserieDocumental::when(
            $request->filled('serie_id'),
            fn($q) => $q->where('serie_documental_id', $request->serie_id)
        )->pluck('nombre', 'id');
        $estados      = ['activo' => 'Activo', 'prestado' => 'Prestado', 'vencido' => 'Vencido'];

        // Aquí en lugar de pluck('nombre','id') armamos el array:
        $ubicaciones = Ubicacion::get()->mapWithKeys(function ($u) {
            $label = collect([
                $u->estante,
                $u->bandeja,
                $u->caja   ? "Caja {$u->caja}"   : null,
                $u->carpeta ? "Carpeta {$u->carpeta}" : null,
                $u->otro,
            ])->filter()->implode(' / ');
            return [$u->id => $label];
        });

        return view('inventarios.detalles_transferencias.index', compact(
            'detalles',
            'dependencias',
            'series',
            'subseries',
            'ubicaciones',
            'estados'
        ));
    }

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

        return back()->with('success', 'Detalle agregado');
    }

    /**
     * Soft‐delete de un detalle individual.
     */
    public function destroy(DetallesTransferenciaDocumental $detalle)
    {
        $detalle->delete();
        return back()->with('success', 'Detalle eliminado');
    }
}
