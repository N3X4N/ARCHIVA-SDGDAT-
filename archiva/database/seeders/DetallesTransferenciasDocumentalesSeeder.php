<?php

namespace Database\Seeders;

use App\Models\DetallesTransferenciaDocumental;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\DetalleTransferenciaDocumental; // Ensure this is the correct namespace for the model
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
        // Detalles para las transferencias existentes
        $detalles = [
            [
                'transferencia_id' => 1, // Cambiado a 4 para coincidir con los IDs existentes
                'ubicacion_id' => 1, // Asegúrate de que este ID existe en ubicaciones
                'numero_orden' => '001',
                'codigo' => '124.74.87',
                'nombre_series_subserie' => 'Unidad de Conservación',
                'fecha_inicial' => Carbon::parse('2021-07-27')->format('Y-m-d'),
                'fecha_final' => Carbon::parse('2022-01-12')->format('Y-m-d'),
                'caja' => 50,
                'carpeta' => 1,
                'resolucion' => 115,
                'tomo' => null,
                'otro' => null,
                'numero_folios' => 38,
                'soporte' => 'Papel',
                'frecuencia_consulta' => 'Media',
                'ubicacion_caja' => 'Caja 1',
                'ubicacion_bandeja' => 'Bandeja A',
                'ubicacion_estante' => 'Estante B',
                'observaciones' => '2 Planos',
                'estado_flujo' => 'Activo',
            ],
            [
                'transferencia_id' => 2, // Cambiado a 5
                'ubicacion_id' => 1,
                'numero_orden' => '002',
                'codigo' => '116.74.87',
                'nombre_series_subserie' => 'Unidad de Conservación',
                'fecha_inicial' => Carbon::parse('2022-05-27')->format('Y-m-d'),
                'fecha_final' => Carbon::parse('2023-01-12')->format('Y-m-d'),
                'caja' => 60,
                'carpeta' => 2,
                'resolucion' => 116,
                'tomo' => null,
                'otro' => null,
                'numero_folios' => 47,
                'soporte' => 'Papel',
                'frecuencia_consulta' => 'Alta',
                'ubicacion_caja' => 'Caja 2',
                'ubicacion_bandeja' => 'Bandeja B',
                'ubicacion_estante' => 'Estante C',
                'observaciones' => '3 Planos',
                'estado_flujo' => 'Activo',
            ],
            [
                'transferencia_id' => 3, // Cambiado a 6
                'ubicacion_id' => 1,
                'numero_orden' => '003',
                'codigo' => '117.74.87',
                'nombre_series_subserie' => 'Unidad de Conservación',
                'fecha_inicial' => Carbon::parse('2023-05-27')->format('Y-m-d'),
                'fecha_final' => Carbon::parse('2024-01-12')->format('Y-m-d'),
                'caja' => 70,
                'carpeta' => 3,
                'resolucion' => 117,
                'tomo' => null,
                'otro' => null,
                'numero_folios' => 58,
                'soporte' => 'Digital',
                'frecuencia_consulta' => 'Baja',
                'ubicacion_caja' => 'Caja 3',
                'ubicacion_bandeja' => 'Bandeja C',
                'ubicacion_estante' => 'Estante D',
                'observaciones' => '4 Planos',
                'estado_flujo' => 'prestado',
            ],
            // Agregar más detalles según sea necesario
        ];

        foreach ($detalles as $detalle) {
            DetallesTransferenciaDocumental::create($detalle);
        }
    }
}
