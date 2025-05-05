<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TransferenciaDocumental;
use App\Models\Dependencia;
use App\Models\SerieDocumental;
use App\Models\SubserieDocumental;
use App\Models\Ubicacion;
use App\Models\Soporte;
use App\Models\User;
use Faker\Factory as Faker;
use Carbon\Carbon;

class TransferenciaDocumentalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create 3 sample TransferenciaDocumental
        $transferencias = [
            [
                'user_id' => 1, // Example user ID
                'dependencia_id' => 1, // Example dependencia ID
                'ubicacion_id' => 1, // Example ubicacion ID
                'entidad_productora' => 'SECRETARIA DE PLANEACION',
                'unidad_administrativa' => 'ALCALDIA MUNICIPAL DE TABIO',
                'oficina_productora' => 'SECRETARIA DE PLANEACION',
                'registro_entrada' => Carbon::now()->format('Y-m-d'),
                'numero_transferencia' => '1',
                'objeto' => 'ORGANIZACIÓN INVENTARIO DOCUMENTAL DE LA VIGENCIA 2021',
                'estado_flujo' => 'ingreso',
                'is_active' => true,
            ],
            [
                'user_id' => 2, // Example user ID
                'dependencia_id' => 1, // Example dependencia ID
                'ubicacion_id' => 1, // Example ubicacion ID
                'entidad_productora' => 'SECRETARIA DE EDUCACION',
                'unidad_administrativa' => 'ALCALDIA DE BOGOTA',
                'oficina_productora' => 'SECRETARIA DE EDUCACION',
                'registro_entrada' => Carbon::now()->format('Y-m-d'),
                'numero_transferencia' => '2',
                'objeto' => 'ACTUALIZACION DE INVENTARIO 2022',
                'estado_flujo' => 'prestado',
                'is_active' => true,
            ],
            [
                'user_id' => 1, // Example user ID
                'dependencia_id' => 1, // Example dependencia ID
                'ubicacion_id' => 1, // Example ubicacion ID
                'entidad_productora' => 'SECRETARIA DE SALUD',
                'unidad_administrativa' => 'MUNICIPIO DE MEDELLIN',
                'oficina_productora' => 'SECRETARIA DE SALUD',
                'registro_entrada' => Carbon::now()->format('Y-m-d'),
                'numero_transferencia' => '3',
                'objeto' => 'INVENTARIO HISTORICO DE LA VIGENCIA 2023',
                'estado_flujo' => 'ingreso',
                'is_active' => true,
            ]
        ];

        foreach ($transferencias as $transferencia) {
            TransferenciaDocumental::create($transferencia);
        }
    }
}
