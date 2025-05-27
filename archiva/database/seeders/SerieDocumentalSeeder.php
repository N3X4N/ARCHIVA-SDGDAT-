<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SerieDocumental;
use App\Models\TipoDocumental;

class SerieDocumentalSeeder extends Seeder
{
    public function run()
    {
        // Obtener el ID del tipo "PRINCIPAL"
        $principalTypeId = TipoDocumental::where('nombre', 'PRINCIPAL')->value('id');

        $series = [
            ['codigo' => '04',                    'nombre' => 'ACCIONES'],
            ['codigo' => '01',                    'nombre' => 'ACCIONES CONSTITUCIONALES'],
            ['codigo' => '02',                    'nombre' => 'ACCIONES JUDICIALES'],
            ['codigo' => '01-02-03',              'nombre' => 'ACTAS'],
            ['codigo' => '02',                    'nombre' => 'ACUERDOS DE PAGO'],
            ['codigo' => '02',                    'nombre' => 'AUDITORÍAS'],
            ['codigo' => '03',                    'nombre' => 'AUTORIZACIONES'],
            ['codigo' => '04',                    'nombre' => 'BOLETINES'],
            ['codigo' => '02-03-04',              'nombre' => 'CERTIFICACIONES'],
            ['codigo' => '02-04-05',              'nombre' => 'CIRCULARES'],
            ['codigo' => '04-05',                 'nombre' => 'COMISIONES Y DILIGENCIAS'],
            ['codigo' => '04-06',                 'nombre' => 'COMPROBANTES'],
            ['codigo' => '05',                    'nombre' => 'CONCEPTOS'],
            ['codigo' => '05',                    'nombre' => 'CONCILIACIONES'],
            ['codigo' => '05',                    'nombre' => 'CONSTANCIAS'],
            ['codigo' => '05',                    'nombre' => 'CONTRATOS'],
            ['codigo' => '07',                    'nombre' => 'DECLARACIONES TRIBUTARIAS'],
            ['codigo' => '14',                    'nombre' => 'DECLARATORIAS'],
            ['codigo' => '06',                    'nombre' => 'DECRETOS MUNICIPALES'],
            ['codigo' => '06',                    'nombre' => 'DEMARCACIONES'],
            ['codigo' => '05-06',                 'nombre' => 'DENUNCIAS'],
            ['codigo' => '01-04-05-06-07-08',     'nombre' => 'DERECHOS DE PETICIÓN'],
            ['codigo' => '05',                    'nombre' => 'DIMENCIONES TRANSVERSALES POBLACIÓN VULNERABLE'],
            ['codigo' => '02-03-06-07-08-09',      'nombre' => 'DOCUMENTOS SISTEMA INTEGRADO DE GESTIÓN DE CALIDAD'],
            ['codigo' => '10',                    'nombre' => 'ESTADOS FINANCIEROS'],
            ['codigo' => '06',                    'nombre' => 'EVALUACIÓN'],
            ['codigo' => '10',                    'nombre' => 'FICHAS'],
            ['codigo' => '07',                    'nombre' => 'FORTALECIMIENTO DE LA AUTORIDAD SANITARIA'],
            ['codigo' => '08',                    'nombre' => 'HISTORIAS'],
            ['codigo' => '05-07-08-09-11',         'nombre' => 'INFORMES'],
            ['codigo' => '04-08-09-10-12',         'nombre' => 'INSTRUMENTOS DE DESCRIPCIÓN Y CONSULTA'],
            ['codigo' => '10-11',                 'nombre' => 'INVENTARIOS'],
            ['codigo' => '12',                    'nombre' => 'LIBROS CONTABLES'],
            ['codigo' => '13',                    'nombre' => 'LICENCIAS'],
            ['codigo' => '09-11-12',              'nombre' => 'MANUALES'],
            ['codigo' => '13',                    'nombre' => 'NÓMINA'],
            ['codigo' => '13',                    'nombre' => 'PARTICIPACIÓN CIUDADANA'],
            ['codigo' => '13',                    'nombre' => 'PERIÓDICO INSTITUCIONAL'],
            ['codigo' => '05-07-09-10-11-12-14',   'nombre' => 'PETICIONES, QUEJAS, RECLAMOS Y SUGERENCIAS'],
            ['codigo' => '06-10-11-12-14-15',      'nombre' => 'PLANES'],
            ['codigo' => '16',                    'nombre' => 'PÓLIZAS'],
            ['codigo' => '07-12-13-15-16-17',      'nombre' => 'PROCESOS'],
            ['codigo' => '13-14-15-16',            'nombre' => 'PROGRAMAS'],
            ['codigo' => '12-15-16-17',            'nombre' => 'PROYECTOS'],
            ['codigo' => '18',                    'nombre' => 'RECIBOS'],
            ['codigo' => '18',                    'nombre' => 'REGISTROS'],
            ['codigo' => '19',                    'nombre' => 'RESERVAS PRESUPUESTALES'],
            ['codigo' => '19',                    'nombre' => 'RESOLUCIONES ADMINISTRATIVAS'],
            ['codigo' => '14',                    'nombre' => 'UNIDAD DE ATENCIÓN INTEGRAL UAID'],
            ['codigo' => '12',                    'nombre' => 'VIGILANCIA EPIDEMIOLÓGICA'],
            ['codigo' => '15',                    'nombre' => 'VISITAS'],
        ];

        foreach ($series as $item) {
            $serie = SerieDocumental::create([
                'serie_padre_id' => null,
                'codigo'         => $item['codigo'],
                'nombre'         => $item['nombre'],
                'observaciones'  => null,
                'is_active'      => true,
            ]);

            // Asociar siempre al tipo "PRINCIPAL"
            if ($principalTypeId) {
                $serie->tiposDocumentales()->sync([$principalTypeId]);
            }
        }
    }
}
