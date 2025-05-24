<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TransferenciaDocumental;
use Carbon\Carbon;

class TransferenciaDocumentalSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        $transferencias = [
            // 1) Solo elaborado
            [
                'user_id'                => 1,
                'entidad_remitente_id'   => 1,  // Antes dependencia_id
                'entidad_productora_id'  => 1,  // Nuevo FK
                'oficina_productora_id'  => 1,  // Nuevo FK
                'unidad_administrativa'  => 'ALCALDIA MUNICIPAL DE TABIO',
                'registro_entrada'       => $now->copy()->subDays(3)->toDateString(),
                'numero_transferencia'   => '1',
                'objeto'                 => 'ORGANIZACIÓN INVENTARIO DOCUMENTAL 2021',
                'estado_flujo'           => 'ELABORADO',
                'is_active'              => true,

                // firmas
                'elaborado_por'          => 1,
                'elaborado_fecha'        => $now->copy()->subDays(3),
            ],

            // 2) Elaborado + Entregado
            [
                'user_id'                => 2,
                'entidad_remitente_id'   => 1,
                'entidad_productora_id'  => 2,
                'oficina_productora_id'  => 2,
                'unidad_administrativa'  => 'ALCALDIA DE BOGOTA',
                'registro_entrada'       => $now->copy()->subDays(2)->toDateString(),
                'numero_transferencia'   => '2',
                'objeto'                 => 'ACTUALIZACIÓN INVENTARIO 2022',
                'estado_flujo'           => 'ENTREGADO',
                'is_active'              => true,

                'elaborado_por'          => 2,
                'elaborado_fecha'        => $now->copy()->subDays(2),
                'entregado_por'          => 3,
                'entregado_fecha'        => $now->copy()->subDay(),
            ],

            // 3) Elaborado + Entregado + Recibido
            [
                'user_id'                => 1,
                'entidad_remitente_id'   => 1,
                'entidad_productora_id'  => 3,
                'oficina_productora_id'  => 3,
                'unidad_administrativa'  => 'MUNICIPIO DE MEDELLIN',
                'registro_entrada'       => $now->copy()->subDays(5)->toDateString(),
                'numero_transferencia'   => '3',
                'objeto'                 => 'INVENTARIO HISTÓRICO VIGENCIA 2023',
                'estado_flujo'           => 'RECIBIDO',
                'is_active'              => true,

                'elaborado_por'          => 1,
                'elaborado_fecha'        => $now->copy()->subDays(5),
                'entregado_por'          => 2,
                'entregado_fecha'        => $now->copy()->subDays(4),
                'recibido_por'           => 3,
                'recibido_fecha'         => $now->copy()->subDays(3),
            ],
        ];

        foreach ($transferencias as $data) {
            TransferenciaDocumental::create($data);
        }
    }
}
