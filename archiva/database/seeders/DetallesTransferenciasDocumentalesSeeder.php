<?php

namespace Database\Seeders;

use App\Models\DetallesTransferenciaDocumental;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\TransferenciaDocumental;
use App\Models\SerieDocumental;
use App\Models\SubserieDocumental; // Ensure this is the correct namespace for the model
use Faker\Factory as Faker;

class DetallesTransferenciasDocumentalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Cada elemento describes una fila, indicando transferencia y serie/subserie
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
                'otro'                   => null,
                'numero_folios'          => 38,
                'soporte'                => 'Papel',
                'frecuencia_consulta'    => 'Media',
                'ubicacion_caja'         => 'Caja 1',
                'ubicacion_bandeja'      => 'Bandeja A',
                'ubicacion_estante'      => 'Estante B',
                'observaciones'          => '2 Planos',
                'estado_flujo'           => 'Activo',
            ],
            [
                'transferencia_id'       => 2,
                'ubicacion_id'           => 1,
                'serie_documental_id'    => 2,
                'subserie_documental_id' => null,
                'numero_orden'           => '002',
                'fecha_inicial'          => '2022-05-27',
                'fecha_final'            => '2023-01-12',
                'caja'                   => 60,
                'carpeta'                => 2,
                'resolucion'             => 116,
                'tomo'                   => null,
                'otro'                   => null,
                'numero_folios'          => 47,
                'soporte'                => 'Papel',
                'frecuencia_consulta'    => 'Alta',
                'ubicacion_caja'         => 'Caja 2',
                'ubicacion_bandeja'      => 'Bandeja B',
                'ubicacion_estante'      => 'Estante C',
                'observaciones'          => '3 Planos',
                'estado_flujo'           => 'Activo',
            ],
            [
                'transferencia_id'       => 3,
                'ubicacion_id'           => 1,
                'serie_documental_id'    => 3,
                'subserie_documental_id' => null,
                'numero_orden'           => '003',
                'fecha_inicial'          => '2023-05-27',
                'fecha_final'            => '2024-01-12',
                'caja'                   => 70,
                'carpeta'                => 3,
                'resolucion'             => 117,
                'tomo'                   => null,
                'otro'                   => null,
                'numero_folios'          => 58,
                'soporte'                => 'Digital',
                'frecuencia_consulta'    => 'Baja',
                'ubicacion_caja'         => 'Caja 3',
                'ubicacion_bandeja'      => 'Bandeja C',
                'ubicacion_estante'      => 'Estante D',
                'observaciones'          => '4 Planos',
                'estado_flujo'           => 'Prestado',
            ],
            // … añade más filas si lo necesitas …
        ];

        foreach ($rows as $r) {
            // 1) obtengo la transferencia y su dependencia
            $trans = TransferenciaDocumental::findOrFail($r['transferencia_id']);
            $depCode = $trans->dependencia->codigo;

            // 2) obtengo serie y subserie
            $serie = SerieDocumental::findOrFail($r['serie_documental_id']);
            $sub   = $r['subserie_documental_id']
                      ? SubserieDocumental::find($r['subserie_documental_id'])
                      : null;

            // 3) genero el código: DEP.SERIE.SUB o DEP.SERIE.00
            $serieCode = $serie->codigo;
            $subCode   = $sub ? $sub->codigo : '00';
            $codigo    = "{$depCode}.{$serieCode}.{$subCode}";

            // 4) creo el detalle
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
                'otro'                    => $r['otro'],
                'numero_folios'           => $r['numero_folios'],
                'soporte'                 => $r['soporte'],
                'frecuencia_consulta'     => $r['frecuencia_consulta'],
                'ubicacion_caja'          => $r['ubicacion_caja'],
                'ubicacion_bandeja'       => $r['ubicacion_bandeja'],
                'ubicacion_estante'       => $r['ubicacion_estante'],
                'observaciones'           => $r['observaciones'],
                'estado_flujo'            => $r['estado_flujo'],
            ]);
        }
    }
}
