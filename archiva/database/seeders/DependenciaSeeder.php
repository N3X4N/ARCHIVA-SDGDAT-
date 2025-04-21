<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dependencia;

class DependenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Dependencia::create([
            'nombre' => 'Administración',
            'sigla' => 'ADM',  // Agregar valor para sigla
            'codigo' => '001', // Agregar valor para codigo
            'is_active' => 1,
        ]);

        // Puedes agregar más dependencias aquí si lo deseas
    }
}
