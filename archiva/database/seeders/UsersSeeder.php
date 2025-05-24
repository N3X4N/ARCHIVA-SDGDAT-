<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole     = Role::firstOrCreate(['nombre_rol' => 'admin']);
        $archivistaRole = Role::firstOrCreate(['nombre_rol' => 'archivista']);
        $solicitanteRole = Role::firstOrCreate(['nombre_rol' => 'solicitante']);

        // Usuario administrador
        User::updateOrCreate(
            ['email' => 'admin@archivo.local'],
            [
                'name'       => 'Administrador',
                'password'   => Hash::make('123456789'),
                'role_id'    => $adminRole->id,
                'is_active'  => true,
            ]
        );

        // Usuario archivista
        User::updateOrCreate(
            ['email' => 'archivista@archivo.local'],
            [
                'name'       => 'Archivista',
                'password'   => Hash::make('Secret123!'),
                'role_id'    => $archivistaRole->id,
                'is_active'  => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'solicitante@archivo.local'],
            [
                'name'       => 'solicitante',
                'password'   => Hash::make('Secret1544!'),
                'role_id'    => $solicitanteRole->id,
                'is_active'  => true,
            ]
        );
    }
}
