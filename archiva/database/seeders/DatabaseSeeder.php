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
            UsersSeeder::class,
            DependenciaSeeder::class,
            SerieDocumentalSeeder::class,
            SubserieDocumentalSeeder::class,
            UbicacionSeeder::class,
            SoporteSeeder::class,
            TransferenciaDocumentalSeeder::class,
        ]);
    }
}
