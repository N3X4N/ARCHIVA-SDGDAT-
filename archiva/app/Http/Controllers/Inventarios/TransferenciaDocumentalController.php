<?php

namespace App\Http\Controllers\Inventarios;

use App\Http\Controllers\Controller;
use App\Models\TransferenciaDocumental;
use App\Models\Dependencia;
use App\Models\SerieDocumental;
use App\Models\SubserieDocumental;
use App\Models\Ubicacion;
use App\Models\Soporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class TransferenciaDocumentalController extends Controller
{
    /**
     * Listado de transferencias, con filtros opcionales y paginación.
     */
    public function index(Request $request)
    {
        $query = TransferenciaDocumental::with([
            'entidadRemitente',
            'entidadProductora',
            'oficinaProductora',
            'detalles.serie',
            'detalles.subserie',
            'detalles.ubicacion',
            'detalles.soporte',
        ]);

        // Filtros simples…
        foreach (
            [
                'entidad_remitente_id',
                'entidad_productora_id',
                'oficina_productora_id',
                'estado_flujo'
            ] as $field
        ) {
            if ($request->filled($field)) {
                $query->where($field, $request->input($field));
            }
        }
        if ($request->filled('fecha_inicio')) {
            $query->whereDate('registro_entrada', '>=', $request->fecha_inicio);
        }
        if ($request->filled('fecha_fin')) {
            $query->whereDate('registro_entrada', '<=', $request->fecha_fin);
        }

        $transferencias = $query
            ->orderBy('id', 'asc')
            ->paginate(10)
            ->appends($request->only([
                'entidad_remitente_id',
                'entidad_productora_id',
                'oficina_productora_id',
                'estado_flujo',
                'fecha_inicio',
                'fecha_fin',
            ]));

        $dependencias = Dependencia::active()->pluck('nombre', 'id');
        $estados      = TransferenciaDocumental::ESTADOS;

        return view('inventarios.transferencias.index', compact(
            'transferencias',
            'dependencias',
            'estados'
        ));
    }

    /**
     * Formulario para crear nueva transferencia.
     */
    public function create()
    {
        $dependencias        = Dependencia::active()->pluck('nombre', 'id');
        $dependenciasCodigos = Dependencia::active()->pluck('codigo', 'id')->toArray();

        return view('inventarios.transferencias.create', [
            'dependencias'         => $dependencias,
            'dependenciasCodigos'  => $dependenciasCodigos,
            'entidadesProductoras' => $dependencias,
            'oficinasProductoras'  => $dependencias,
            'ubicaciones'          => Ubicacion::active()
                ->get()
                ->mapWithKeys(fn($u) => [
                    $u->id => "Estante: {$u->estante} | Bandeja: {$u->bandeja} | Caja: {$u->caja} | Carpeta: {$u->carpeta} | Otro: {$u->otro}"
                ])
                ->toArray(),
            'seriesList'           => SerieDocumental::active()->pluck('nombre', 'id'),
            'seriesCodes'          => SerieDocumental::active()->pluck('codigo', 'id')->toArray(),
            'subseriesGroup'       => SubserieDocumental::active()
                ->get()
                ->groupBy('serie_documental_id')
                ->map->pluck('nombre', 'id')
                ->toArray(),
            'subseriesCodes'       => SubserieDocumental::active()->pluck('codigo', 'id')->toArray(),
            'soportes'             => Soporte::active()->pluck('nombre', 'id'),
        ]);
    }

    /**
     * Valida y almacena la nueva transferencia con sus detalles.
     */
    public function store(Request $request)
    {
        // 1) Validación cabecera + arrays alineados
        $v = $request->validate([
            'entidad_remitente_id'      => 'required|exists:dependencias,id',
            'entidad_productora_id'     => 'required|exists:dependencias,id',
            'oficina_productora_id'     => 'required|exists:dependencias,id',
            'unidad_administrativa'     => 'required|string',
            'objeto'                    => 'nullable|string',

            // Detalles como arrays
            'numero_orden.*'            => 'required|string',
            'serie_documental_id.*'     => 'required|exists:series_documentales,id',
            'subserie_documental_id.*'  => 'nullable|exists:subseries_documentales,id',
            'codigo.*'                  => 'nullable|string',
            'fecha_inicial.*'           => 'nullable|date',
            'fecha_final.*'             => 'nullable|date',
            'caja.*'                    => 'nullable|integer',
            'carpeta.*'                 => 'nullable|integer',
            'resolucion.*'              => 'nullable|integer',
            'tomo.*'                    => 'nullable|integer',
            'numero_folios.*'           => 'nullable|integer',
            'soporte_id.*'              => 'nullable|exists:soportes,id',
            'ubicacion_id.*'            => 'nullable|exists:ubicaciones,id',
            'frecuencia_consulta.*'     => 'nullable|string',
            'observaciones.*'           => 'nullable|string',
            'estado_flujo.*'            => 'nullable|string',
        ]);

        // 2) Validación de rangos de fecha (igual que antes)
        $this->validateDateRanges($v);

        // 3) Transacción: crear cabecera + detalles
        DB::transaction(function () use ($v, $request) {
            $t = TransferenciaDocumental::create([
                'user_id'               => auth()->id(),
                'entidad_remitente_id'  => $v['entidad_remitente_id'],
                'entidad_productora_id' => $v['entidad_productora_id'],
                'oficina_productora_id' => $v['oficina_productora_id'],
                'unidad_administrativa' => $v['unidad_administrativa'],
                'registro_entrada'      => now(),
                'objeto'                => $v['objeto'] ?? null,
            ]);

            // asignar número automático
            $t->update(['numero_transferencia' => $t->id]);

            // recorro cada posición de numero_orden[]
            foreach ($request->input('numero_orden', []) as $i => $orden) {
                $t->detalles()->create([
                    'serie_documental_id'    => $request->serie_documental_id[$i],
                    'subserie_documental_id' => $request->subserie_documental_id[$i] ?? null,
                    'numero_orden'           => $orden,
                    'codigo'                 => $request->codigo[$i]               ?? null,
                    'nombre_series_subserie' => $request->nombre_series_subserie[$i] ?? null,
                    'fecha_inicial'          => $request->fecha_inicial[$i]         ?? null,
                    'fecha_final'            => $request->fecha_final[$i]           ?? null,
                    'caja'                   => $request->caja[$i]                  ?? null,
                    'carpeta'                => $request->carpeta[$i]               ?? null,
                    'resolucion'             => $request->resolucion[$i]            ?? null,
                    'tomo'                   => $request->tomo[$i]                  ?? null,
                    'numero_folios'          => $request->numero_folios[$i]         ?? null,
                    'soporte_id'             => $request->soporte_id[$i]            ?? null,
                    'ubicacion_id'           => $request->ubicacion_id[$i]          ?? null,
                    'frecuencia_consulta'    => $request->frecuencia_consulta[$i]   ?? null,
                    'observaciones'          => $request->observaciones[$i]         ?? null,
                    'estado_flujo'           => $request->estado_flujo[$i]          ?? 'Activo',
                ]);
            }
        });

        return redirect()
            ->route('inventarios.transferencias.index')
            ->with('success', 'Transferencia creada con éxito');
    }

    /**
     * Valida que las fechas finales sean posteriores o iguales a las iniciales
     */
    private function validateDateRanges(array $data)
    {
        if (empty($data['fecha_inicial']) || empty($data['fecha_final'])) {
            return;
        }
        foreach ($data['fecha_inicial'] as $i => $ini) {
            if ($ini && !empty($data['fecha_final'][$i])) {
                $start = \Carbon\Carbon::parse($ini);
                $end   = \Carbon\Carbon::parse($data['fecha_final'][$i]);
                if ($end->lt($start)) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        "fecha_final.{$i}" => "La fecha final debe ser igual o posterior a la inicial en fila " . ($i + 1)
                    ]);
                }
            }
        }
    }

    /**
     * Formulario para editar una transferencia existente.
     */
    public function edit(TransferenciaDocumental $transferencia)
    {
        // 1) Número siguiente (igual que en create)
        $nextTransferNumber  = (int)(TransferenciaDocumental::max('numero_transferencia') ?? 0) + 1;

        // 2) Dependencias y códigos
        $dependencias        = Dependencia::active()->pluck('nombre', 'id');
        $dependenciasCodigos = Dependencia::active()->pluck('codigo', 'id')->toArray();

        // 3) Reuso listas idénticas a create()
        $entidadesProductoras = $dependencias;
        $oficinasProductoras  = $dependencias;
        $ubicaciones = Ubicacion::active()
            ->get()
            ->mapWithKeys(fn($u) => [
                $u->id => sprintf(
                    'Estante: %s | Bandeja: %s | Caja: %s | Carpeta: %s | Otro: %s',
                    $u->estante,
                    $u->bandeja,
                    $u->caja,
                    $u->carpeta,
                    $u->otro
                )
            ])->toArray();
        $seriesList      = SerieDocumental::active()->pluck('nombre', 'id');
        $seriesCodes     = SerieDocumental::active()->pluck('codigo', 'id')->toArray();
        $subseriesGroup  = SubserieDocumental::active()
            ->get()
            ->groupBy('serie_documental_id')
            ->map->pluck('nombre', 'id')
            ->toArray();
        $subseriesCodes  = SubserieDocumental::active()->pluck('codigo', 'id')->toArray();
        $soportes        = Soporte::active()->pluck('nombre', 'id');

        // 4) Carga detalles para poblar las filas existentes
        $transferencia->load('detalles');

        // 5) Devuelve la vista con el mismo array de keys que create()
        return view('inventarios.transferencias.edit', [
            'transferencia'        => $transferencia,
            'nextTransferNumber'   => $nextTransferNumber,
            'dependencias'         => $dependencias,
            'dependenciasCodigos'  => $dependenciasCodigos,
            'entidadesProductoras' => $entidadesProductoras,
            'oficinasProductoras'  => $oficinasProductoras,
            'ubicaciones'          => $ubicaciones,
            'seriesList'           => $seriesList,
            'seriesCodes'          => $seriesCodes,
            'subseriesGroup'       => $subseriesGroup,
            'subseriesCodes'       => $subseriesCodes,
            'soportes'             => $soportes,
        ]);
    }
    /**
     * Valida y actualiza la transferencia y sus detalles.
     */
    public function update(Request $request, TransferenciaDocumental $transferencia)
    {
        // 1) Validación cabecera + arrays alineados (igual que en store)
        $v = $request->validate([
            'entidad_remitente_id'      => 'required|exists:dependencias,id',
            'entidad_productora_id'     => 'required|exists:dependencias,id',
            'oficina_productora_id'     => 'required|exists:dependencias,id',
            'unidad_administrativa'     => 'required|string',
            'objeto'                    => 'nullable|string',

            // Detalles como arrays
            'numero_orden.*'            => 'required|string',
            'serie_documental_id.*'     => 'required|exists:series_documentales,id',
            'subserie_documental_id.*'  => 'nullable|exists:subseries_documentales,id',
            'codigo.*'                  => 'nullable|string',
            'fecha_inicial.*'           => 'nullable|date',
            'fecha_final.*'             => 'nullable|date',
            'caja.*'                    => 'nullable|integer',
            'carpeta.*'                 => 'nullable|integer',
            'resolucion.*'              => 'nullable|integer',
            'tomo.*'                    => 'nullable|integer',
            'numero_folios.*'           => 'nullable|integer',
            'soporte_id.*'              => 'nullable|exists:soportes,id',
            'ubicacion_id.*'            => 'nullable|exists:ubicaciones,id',
            'frecuencia_consulta.*'     => 'nullable|string',
            'observaciones.*'           => 'nullable|string',
            'estado_flujo.*'            => 'nullable|string',
            'detalle_id.*'              => 'nullable|exists:detalles_transferencias_documentales,id',
        ]);

        // 2) Validación personalizada de rangos
        $this->validateDateRanges($v);

        // 3) Transacción: actualizamos cabecera y sincronizamos detalles
        DB::transaction(function () use ($v, $transferencia) {
            // 3.1) Actualizar sólo los campos modificables de la cabecera
            $transferencia->update([
                'entidad_remitente_id'  => $v['entidad_remitente_id'],
                'entidad_productora_id' => $v['entidad_productora_id'],
                'oficina_productora_id' => $v['oficina_productora_id'],
                'unidad_administrativa' => $v['unidad_administrativa'],
                'objeto'                => $v['objeto'] ?? null,
                // NO tocamos numero_transferencia
            ]);

            // 3.2) Código base para generar si falta
            $depCode = Dependencia::findOrFail($v['entidad_remitente_id'])->codigo;
            $series  = SerieDocumental::whereIn('id', $v['serie_documental_id'])->get()->keyBy('id');
            $subseriesIds = array_filter($v['subserie_documental_id'], fn($id) => !is_null($id));
            $subseries = SubserieDocumental::whereIn('id', $subseriesIds)->get()->keyBy('id');

            // 3.3) Procesar cada detalle
            $incoming = [];
            foreach ($v['numero_orden'] as $i => $orden) {
                $serieId = $v['serie_documental_id'][$i];
                $subId   = $v['subserie_documental_id'][$i] ?? null;

                // Datos comunes
                $data = [
                    'serie_documental_id'    => $serieId,
                    'subserie_documental_id' => $subId,
                    'numero_orden'           => $orden,
                    'fecha_inicial'          => $v['fecha_inicial'][$i]   ?? null,
                    'fecha_final'            => $v['fecha_final'][$i]     ?? null,
                    'caja'                   => $v['caja'][$i]            ?? null,
                    'carpeta'                => $v['carpeta'][$i]         ?? null,
                    'resolucion'             => $v['resolucion'][$i]      ?? null,
                    'tomo'                   => $v['tomo'][$i]            ?? null,
                    'numero_folios'          => $v['numero_folios'][$i]   ?? null,
                    'soporte_id'             => $v['soporte_id'][$i]      ?? null,
                    'ubicacion_id'           => $v['ubicacion_id'][$i]    ?? null,
                    'frecuencia_consulta'    => $v['frecuencia_consulta'][$i] ?? null,
                    'observaciones'          => $v['observaciones'][$i]      ?? null,
                    'estado_flujo'           => $v['estado_flujo'][$i]       ?? 'Activo',
                ];

                // Si no pusieron código, lo generamos
                $serie    = $series[$serieId];
                $subserie = $subId ? $subseries[$subId] : null;
                $data['codigo'] = $v['codigo'][$i]
                    ?? "{$depCode}.{$serie->codigo}." . ($subserie->codigo ?? '00');

                // Actualizar o crear
                if (!empty($v['detalle_id'][$i])) {
                    $d = $transferencia->detalles()->findOrFail($v['detalle_id'][$i]);
                    $d->update($data);
                    $incoming[] = $d->id;
                } else {
                    $new = $transferencia->detalles()->create($data);
                    $incoming[] = $new->id;
                }
            }

            // 3.4) Borrar los detalles que el usuario quitó
            $transferencia->detalles()
                ->whereNotIn('id', $incoming)
                ->delete();
        });

        return redirect()
            ->route('inventarios.transferencias.index')
            ->with('alertType', 'success')
            ->with('alertMessage', 'Transferencia actualizada correctamente');
    }

    /**
     * Soft-delete de la transferencia y sus detalles.
     */
    public function destroy(TransferenciaDocumental $transferencia)
    {
        DB::transaction(function () use ($transferencia) {
            // Soft-delete de detalles (marcará deleted_at)
            $transferencia->detalles()->delete();
            // Soft-delete de la cabecera
            $transferencia->delete();
        });

        return redirect()
            ->route('inventarios.transferencias.index')
            ->with('alertType', 'success')
            ->with('alertMessage', 'Transferencia eliminada correctamente');
    }


    /**
     * Marca como ENTREGADO.
     */
    public function firmarEntregado(TransferenciaDocumental $t)
    {
        $t->update([
            'estado_flujo'   => 'ENTREGADO',
            'entregado_por'  => auth()->id(),
            'entregado_fecha' => now(),
        ]);

        return back()
            ->with('alertType',   'success')
            ->with('alertMessage', 'Firmado como ENTREGADO.');
    }

    /**
     * Marca como RECIBIDO.
     */
    public function firmarRecibido(TransferenciaDocumental $t)
    {
        $t->update([
            'estado_flujo'   => 'RECIBIDO',
            'recibido_por'   => auth()->id(),
            'recibido_fecha' => now(),
        ]);

        return back()
            ->with('alertType',   'success')
            ->with('alertMessage', 'Firmado como RECIBIDO.');
    }

    /**
     * Archiva la transferencia.
     */
    public function archivar(TransferenciaDocumental $t)
    {
        $t->update([
            'estado_flujo' => 'ARCHIVADO',
            'is_active'    => false,
        ]);

        return back()
            ->with('alertType',   'success')
            ->with('alertMessage', 'Transferencia archivada.');
    }
}
