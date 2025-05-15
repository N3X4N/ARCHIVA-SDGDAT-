<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Soporte;

class SoporteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Datos de ejemplo para Soportes
        $soportes = [
            ['nombre' => 'Papelería', 'is_active' => true],
            ['nombre' => 'Digital', 'is_active' => true],
            ['nombre' => 'Microfilm', 'is_active' => true],
            ['nombre' => 'Audio', 'is_active' => true],
            ['nombre' => 'Video', 'is_active' => true],
        ];

        foreach ($soportes as $soporte) {
            Soporte::create($soporte);
        }
    }
}
