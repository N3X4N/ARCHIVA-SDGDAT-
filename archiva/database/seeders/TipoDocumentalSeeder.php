<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoDocumental;

class TipoDocumentalSeeder extends Seeder
{
    public function run()
    {
        $tipos = [
            'ACTA',
            'CONTRATO',
            'INFORME',
            'MEMORANDO',
            'CIRCULAR',
            'RESOLUCIÓN',
            'DECRETO',
            'FACTURA',
            'CERTIFICADO',
            'OFICIO',
        ];

        foreach ($tipos as $nombre) {
            TipoDocumental::firstOrCreate(
                ['nombre' => $nombre],
                ['is_active' => true]
            );
        }
    }
}
