<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::firstOrCreate(
            ['nombre_rol' => 'solicitante'],
            ['description' => 'Usuario que solicita préstamos']
        );

        Role::firstOrCreate(
            ['nombre_rol' => 'archivista'],
            ['description' => 'Gestor del archivo']
        );

        Role::firstOrCreate(
            ['nombre_rol' => 'admin'],
            ['description' => 'Administrador del sistema']
        );
    }
}
