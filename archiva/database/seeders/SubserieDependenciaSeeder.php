<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SubserieDocumental;
use App\Models\Dependencia;

class SubserieDependenciaSeeder extends Seeder
{
    public function run()
    {
        // Mapa: código de subserie => array de siglas de dependencias
        $map = [
            '01-01'        => ['DA'], // Ajusta códigos y siglas según tu CCD
            '01-02'        => ['DA'],
            '01-03'        => ['DA', 'CI', 'SGSCC', 'PML', 'IP', 'CF', 'SSEDS', 'SDAAA', 'SDEYT', 'SGYPC'],
            // … añade aquí todas las subseries y sus dependencias …
        ];

        foreach ($map as $subCode => $siglasDependencias) {
            $subserie = SubserieDocumental::where('codigo', $subCode)->first();
            if (! $subserie) {
                $this->command->warn("Subserie no encontrada: {$subCode}");
                continue;
            }

            $depIds = Dependencia::whereIn('sigla', $siglasDependencias)
                ->pluck('id')
                ->toArray();

            $subserie->dependencias()->sync($depIds);

            $this->command->info("Subserie {$subCode} → dependencias: " . implode(', ', $siglasDependencias));
        }
    }
}
