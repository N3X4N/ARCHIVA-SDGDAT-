<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SerieDocumental;

class SerieDocumentalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Datos de ejemplo para Series Documentales
        $series = [
            ['codigo' => 'S001', 'nombre' => 'Contratos', 'tipo' => 'principal', 'is_active' => true],
            ['codigo' => 'S002', 'nombre' => 'Facturas', 'tipo' => 'principal', 'is_active' => true],
            ['codigo' => 'S003', 'nombre' => 'Informes Financieros', 'tipo' => 'agrupadora', 'is_active' => true],
            ['codigo' => 'S004', 'nombre' => 'Actas de Reunión', 'tipo' => 'principal', 'is_active' => true],
            ['codigo' => 'S005', 'nombre' => 'Correspondencia', 'tipo' => 'principal', 'is_active' => true],
        ];

        foreach ($series as $serie) {
            SerieDocumental::create($serie);
        }
    }
}
