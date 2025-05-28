<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RolesSeeder::class,
            DependenciaSeeder::class,
            UsersSeeder::class,
            TipoDocumentalSeeder::class,
            SerieDocumentalSeeder::class,
            SubserieDocumentalSeeder::class,
            SubserieDependenciaSeeder::class,
            UbicacionSeeder::class,
            SoporteSeeder::class,
            TransferenciaDocumentalSeeder::class,
            DetallesTransferenciasDocumentalesSeeder::class,
        ]);
    }
}
