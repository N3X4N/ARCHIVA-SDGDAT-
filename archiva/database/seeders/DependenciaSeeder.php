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
            'nombre'    => 'Despacho del Alcalde',
            'sigla'     => 'DA',
            'codigo'    => '100',
            'is_active' => 1,
        ]);

        Dependencia::create([
            'nombre'    => 'Oficina Asesora de Control Interno',
            'sigla'     => 'CI',
            'codigo'    => '130',
            'is_active' => 1,
        ]);

        Dependencia::create([
            'nombre'    => 'Secretaría de Gobierno Seguridad y Convivencia Ciudadana',
            'sigla'     => 'SGSCC',
            'codigo'    => '200',
            'is_active' => 1,
        ]);

        Dependencia::create([
            'nombre'    => 'Secretaría de Planeación',
            'sigla'     => 'PML',
            'codigo'    => '140',
            'is_active' => 1,
        ]);

        Dependencia::create([
            'nombre'    => 'Inspección de Policía',
            'sigla'     => 'IP',
            'codigo'    => '201',
            'is_active' => 1,
        ]);

        Dependencia::create([
            'nombre'    => 'Comisaría de Familia',
            'sigla'     => 'CF',
            'codigo'    => '202',
            'is_active' => 1,
        ]);

        Dependencia::create([
            'nombre'    => 'Secretaría de Hacienda',
            'sigla'     => 'SH',
            'codigo'    => '210',
            'is_active' => 1,
        ]);

        Dependencia::create([
            'nombre'    => 'Secretaría de Integración Social',
            'sigla'     => 'SSEDS',
            'codigo'    => '230',
            'is_active' => 1,
        ]);

        Dependencia::create([
            'nombre'    => 'Secretaría de Ambiente y Asuntos Agropecuarios',
            'sigla'     => 'SDAAA',
            'codigo'    => '240',
            'is_active' => 1,
        ]);

        Dependencia::create([
            'nombre'    => 'Secretaría de Desarrollo Económico y Turístico',
            'sigla'     => 'SDEYT',
            'codigo'    => '250',
            'is_active' => 1,
        ]);

        Dependencia::create([
            'nombre'    => 'Secretaría General y Participación Ciudadana',
            'sigla'     => 'SGYPC',
            'codigo'    => '260',
            'is_active' => 1,
        ]);
    }
}
