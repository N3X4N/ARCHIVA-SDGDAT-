<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\User;
use App\Models\Perfil;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $adminRole       = Role::firstOrCreate(['nombre_rol' => 'admin']);
        $archivistaRole  = Role::firstOrCreate(['nombre_rol' => 'archivista']);
        $solicitanteRole = Role::firstOrCreate(['nombre_rol' => 'solicitante']);

        // Usuario administrador
        $admin = User::updateOrCreate(
            ['email' => 'admin@archivo.local'],
            [
                'password'  => Hash::make('123456789'),
                'role_id'   => $adminRole->id,
                'is_active' => true,
            ]
        );

        Perfil::updateOrCreate(
            ['user_id' => $admin->id],
            [
                'nombres'         => 'Administrador',
                'apellidos'       => 'General',
                'dependencia_id'  => null,
                'firma_digital'   => null,
            ]
        );

        // Usuario archivista
        $archivista = User::updateOrCreate(
            ['email' => 'archivista@archivo.local'],
            [
                'password'  => Hash::make('Secret123!'),
                'role_id'   => $archivistaRole->id,
                'is_active' => true,
            ]
        );

        Perfil::updateOrCreate(
            ['user_id' => $archivista->id],
            [
                'nombres'         => 'Marcela',
                'apellidos'       => 'Rozo',
                'dependencia_id'  => 1,
                'firma_digital'   => null,
            ]
        );

        // Usuario solicitante
        $solicitante = User::updateOrCreate(
            ['email' => 'solicitante@archivo.local'],
            [
                'password'  => Hash::make('Secret1544!'),
                'role_id'   => $solicitanteRole->id,
                'is_active' => true,
            ]
        );

        Perfil::updateOrCreate(
            ['user_id' => $solicitante->id],
            [
                'nombres'         => 'Johan',
                'apellidos'       => 'Pruebas',
                'dependencia_id'  => null,
                'firma_digital'   => null,
            ]
        );
    }
}
