<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubserieDocumental;
use App\Models\SerieDocumental;

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

        foreach ($series as $serie) {
            // Dependiendo de la serie, creamos las subseries
            if ($serie->codigo === 'S001') {
                SubserieDocumental::create([
                    'serie_documental_id' => $serie->id,
                    'codigo' => 'S001-1',
                    'nombre' => 'Contratos de Proveedores',
                    'is_active' => true
                ]);
                SubserieDocumental::create([
                    'serie_documental_id' => $serie->id,
                    'codigo' => 'S001-2',
                    'nombre' => 'Contratos de Empleados',
                    'is_active' => true
                ]);
            }

            if ($serie->codigo === 'S002') {
                SubserieDocumental::create([
                    'serie_documental_id' => $serie->id,
                    'codigo' => 'S002-1',
                    'nombre' => 'Facturas Emitidas',
                    'is_active' => true
                ]);
                SubserieDocumental::create([
                    'serie_documental_id' => $serie->id,
                    'codigo' => 'S002-2',
                    'nombre' => 'Facturas Recibidas',
                    'is_active' => true
                ]);
            }

            // Añadir más condiciones según sea necesario para otras series
        }
    }
}
