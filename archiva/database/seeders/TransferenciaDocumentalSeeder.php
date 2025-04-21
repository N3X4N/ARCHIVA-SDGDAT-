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

class TransferenciaDocumentalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();  // Instancia de Faker para generar datos aleatorios

        // Obtener algunos usuarios y dependencias para asociarlos
        $users = User::all();
        $dependencias = Dependencia::all();
        $series = SerieDocumental::all();
        $subseries = SubserieDocumental::all();
        $ubicaciones = Ubicacion::all();
        $soportes = Soporte::all();

        // Crear registros en la tabla 'transferencias_documentales'
        foreach (range(1, 10) as $index) {  // Cambia 10 por la cantidad de registros que deseas insertar
            TransferenciaDocumental::create([
                'user_id'               => $users->random()->id,
                'dependencia_id'        => $dependencias->random()->id,
                'serie_documental_id'   => $series->random()->id,
                'subserie_documental_id'=> $subseries->random()->id,
                'ubicacion_id'          => $ubicaciones->random()->id,
                'soporte_id'            => $soportes->random()->id,
                'oficina_productora'    => $faker->company,
                'registro_entrada'      => $faker->date(),
                'numero_transferencia'  => $faker->word,
                'objeto'                => $faker->sentence,
                'numero_orden'          => $faker->word,
                'codigo_interno'        => $faker->unique()->word,
                'fecha_extrema_inicial' => $faker->date(),
                'fecha_extrema_final'   => $faker->date(),
                'numero_folios'         => $faker->numberBetween(1, 100),
                'frecuencia_consulta'   => $faker->word,
                'observaciones'         => $faker->text,
                'estado_flujo'          => $faker->randomElement(['ingreso', 'egreso']),
                'is_active'             => true,
            ]);
        }
    }
}
