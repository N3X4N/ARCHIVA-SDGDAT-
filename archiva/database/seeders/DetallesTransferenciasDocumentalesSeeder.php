<?php

namespace Database\Seeders;

use App\Models\DetallesTransferenciaDocumental;
use App\Models\TransferenciaDocumental;
use App\Models\SerieDocumental;
use App\Models\SubserieDocumental;
use App\Models\Ubicacion;
use App\Models\Soporte;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DetallesTransferenciasDocumentalesSeeder extends Seeder
{
    public function run()
    {
        $rows = [
            [
                'transferencia_id'       => 1,
                'ubicacion_id'           => 1,
                'serie_documental_id'    => 1,
                'subserie_documental_id' => null,
                'numero_orden'           => '001',
                'fecha_inicial'          => '2021-07-27',
                'fecha_final'            => '2022-01-12',
                'caja'                   => 50,
                'carpeta'                => 1,
                'resolucion'             => 115,
                'tomo'                   => null,
                'numero_folios'          => 38,
                'soporte'                => 'Papel',      // nombre de soporte
                'frecuencia_consulta'    => 'Media',
                'observaciones'          => '2 Planos',
                'estado_flujo'           => 'Activo',
            ],
            // … más filas …
        ];

        foreach ($rows as $r) {
            // 1) Cargo transferencia, dependencia, serie y (opcional) subserie
            $trans = TransferenciaDocumental::findOrFail($r['transferencia_id']);
            $depCode = $trans->entidadRemitente->codigo;

            $serie = SerieDocumental::findOrFail($r['serie_documental_id']);
            $sub   = $r['subserie_documental_id']
                ? SubserieDocumental::find($r['subserie_documental_id'])
                : null;

            // 2) Genero el código compuesto
            $serieCode = $serie->codigo;
            $subCode   = $sub ? $sub->codigo : '00';
            $codigo    = "{$depCode}.{$serieCode}.{$subCode}";
            $nombreSS  = $sub
                ? "{$serie->nombre} / {$sub->nombre}"
                : $serie->nombre;

            // 3) Busco el soporte por nombre para obtener su ID
            $soporteModel = Soporte::where('nombre', $r['soporte'])->first();
            $soporteId    = $soporteModel ? $soporteModel->id : null;

            // 4) Cargo la ubicación real para rellenar sus campos
            $ubic = Ubicacion::find($r['ubicacion_id']);

            DetallesTransferenciaDocumental::create([
                'transferencia_id'        => $trans->id,
                'ubicacion_id'            => $r['ubicacion_id'],
                'numero_orden'            => $r['numero_orden'],
                'codigo'                  => $codigo,
                'serie_documental_id'     => $serie->id,
                'subserie_documental_id'  => $sub?->id,
                'fecha_inicial'           => Carbon::parse($r['fecha_inicial'])->toDateString(),
                'fecha_final'             => Carbon::parse($r['fecha_final'])->toDateString(),
                'caja'                    => $r['caja'],
                'carpeta'                 => $r['carpeta'],
                'resolucion'              => $r['resolucion'],
                'tomo'                    => $r['tomo'],
                'numero_folios'           => $r['numero_folios'],
                'soporte_id'              => $soporteId,                              // ← aquí
                'frecuencia_consulta'     => $r['frecuencia_consulta'],
                'observaciones'           => $r['observaciones'],
                'estado_flujo'            => $r['estado_flujo'],
            ]);
        }
    }
}
