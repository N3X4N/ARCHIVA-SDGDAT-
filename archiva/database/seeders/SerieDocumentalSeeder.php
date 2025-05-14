<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SerieDocumental;
use App\Models\TipoDocumental;

class SerieDocumentalSeeder extends Seeder
{
    public function run()
    {
        // Define cada serie y sus tipos documentales asociados
        $series = [
            [
                'codigo'        => 'S001',
                'nombre'        => 'Contratos',
                'observaciones' => null,
                'is_active'     => true,
                'tipos'         => ['CONTRATO'],
            ],
            [
                'codigo'        => 'S002',
                'nombre'        => 'Facturas',
                'observaciones' => null,
                'is_active'     => true,
                'tipos'         => ['FACTURA'],
            ],
            [
                'codigo'        => 'S003',
                'nombre'        => 'Informes Financieros',
                'observaciones' => null,
                'is_active'     => true,
                'tipos'         => ['INFORME'],
            ],
            [
                'codigo'        => 'S004',
                'nombre'        => 'Actas de Reunión',
                'observaciones' => null,
                'is_active'     => true,
                'tipos'         => ['ACTA'],
            ],
            [
                'codigo'        => 'S005',
                'nombre'        => 'Correspondencia',
                'observaciones' => null,
                'is_active'     => true,
                'tipos'         => ['MEMORANDO', 'CIRCULAR'],
            ],
        ];

        foreach ($series as $data) {
            // 1) Crear la serie
            $serie = SerieDocumental::create([
                'serie_padre_id' => null,
                'codigo'         => $data['codigo'],
                'nombre'         => $data['nombre'],
                'observaciones'  => $data['observaciones'],
                'is_active'      => $data['is_active'],
            ]);

            // 2) Asociar los tipos documentales en la tabla pivote
            $tipoIds = TipoDocumental::whereIn('nombre', $data['tipos'])
                ->pluck('id')
                ->toArray();
            $serie->tiposDocumentales()->sync($tipoIds);
        }
    }
}
