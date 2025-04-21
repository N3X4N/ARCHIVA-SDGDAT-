<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ubicacion;

class UbicacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Datos de ejemplo para Ubicaciones
        $ubicaciones = [
            [
                'estante' => 'Estante 1',
                'bandeja' => 'Bandeja A',
                'caja' => 'Caja 001',
                'carpeta' => 'Carpeta X',
                'otro' => 'Otro lugar',
                'is_active' => true,
            ],
            [
                'estante' => 'Estante 2',
                'bandeja' => 'Bandeja B',
                'caja' => 'Caja 002',
                'carpeta' => 'Carpeta Y',
                'otro' => 'Otro lugar',
                'is_active' => true,
            ],
            [
                'estante' => 'Estante 3',
                'bandeja' => 'Bandeja C',
                'caja' => 'Caja 003',
                'carpeta' => 'Carpeta Z',
                'otro' => 'Otro lugar',
                'is_active' => true,
            ],
            [
                'estante' => 'Estante 4',
                'bandeja' => 'Bandeja D',
                'caja' => 'Caja 004',
                'carpeta' => 'Carpeta W',
                'otro' => 'Otro lugar',
                'is_active' => true,
            ],
            [
                'estante' => 'Estante 5',
                'bandeja' => 'Bandeja E',
                'caja' => 'Caja 005',
                'carpeta' => 'Carpeta V',
                'otro' => 'Otro lugar',
                'is_active' => true,
            ],
        ];

        // Insertar las ubicaciones en la base de datos
        foreach ($ubicaciones as $ubicacion) {
            Ubicacion::create($ubicacion);
        }
    }
}
