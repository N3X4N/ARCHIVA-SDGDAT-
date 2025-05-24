<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubserieDocumental;
use App\Models\SerieDocumental;
use Carbon\Carbon;

class SubserieDocumentalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Obtener las series existentes
        $series = SerieDocumental::all();
        $now = Carbon::now();

        foreach ($series as $serie) {
            // Subseries para la serie S001
            if ($serie->codigo === '01') {
                // ACCIONES CONSTITUCIONALES
                SubserieDocumental::create([
                    'serie_documental_id' => $serie->id,
                    'codigo'              => '01',
                    'nombre'              => 'Acciones de Cumplimiento',
                    'is_active'           => true,
                    'created_at'          => $now,
                    'updated_at'          => $now,
                ]);
                SubserieDocumental::create([
                    'serie_documental_id' => $serie->id,
                    'codigo'              => '02',
                    'nombre'              => 'Acciones de Grupo',
                    'is_active'           => true,
                    'created_at'          => $now,
                    'updated_at'          => $now,
                ]);
                SubserieDocumental::create([
                    'serie_documental_id' => $serie->id,
                    'codigo'              => '03',
                    'nombre'              => 'Acciones de Tutela',
                    'is_active'           => true,
                    'created_at'          => $now,
                    'updated_at'          => $now,
                ]);
                SubserieDocumental::create([
                    'serie_documental_id' => $serie->id,
                    'codigo'              => '04',
                    'nombre'              => 'Acciones Populares',
                    'is_active'           => true,
                    'created_at'          => $now,
                    'updated_at'          => $now,
                ]);
            }


            // Subseries para la serie S002
            if ($serie->codigo === '02') {
                // ACCIONES JUDICIALES
                SubserieDocumental::create([
                    'serie_documental_id' => $serie->id,
                    'codigo'              => '01',
                    'nombre'              => 'Acciones Contractuales',
                    'is_active'           => true,
                    'created_at'          => $now,
                    'updated_at'          => $now,
                ]);
                SubserieDocumental::create([
                    'serie_documental_id' => $serie->id,
                    'codigo'              => '02',
                    'nombre'              => 'Acciones de Nulidad',
                    'is_active'           => true,
                    'created_at'          => $now,
                    'updated_at'          => $now,
                ]);
                SubserieDocumental::create([
                    'serie_documental_id' => $serie->id,
                    'codigo'              => '03',
                    'nombre'              => 'Acciones de Nulidad y Restablecimiento del Derecho',
                    'is_active'           => true,
                    'created_at'          => $now,
                    'updated_at'          => $now,
                ]);
                SubserieDocumental::create([
                    'serie_documental_id' => $serie->id,
                    'codigo'              => '04',
                    'nombre'              => 'Acciones de Reparación Directa',
                    'is_active'           => true,
                    'created_at'          => $now,
                    'updated_at'          => $now,
                ]);
                SubserieDocumental::create([
                    'serie_documental_id' => $serie->id,
                    'codigo'              => '05',
                    'nombre'              => 'Acciones de Repetición',
                    'is_active'           => true,
                    'created_at'          => $now,
                    'updated_at'          => $now,
                ]);
                SubserieDocumental::create([
                    'serie_documental_id' => $serie->id,
                    'codigo'              => '06',
                    'nombre'              => 'Acciones Ordinarias',
                    'is_active'           => true,
                    'created_at'          => $now,
                    'updated_at'          => $now,
                ]);
            }


            // Añadir más condiciones según sea necesario para otras series
        }
    }
}
