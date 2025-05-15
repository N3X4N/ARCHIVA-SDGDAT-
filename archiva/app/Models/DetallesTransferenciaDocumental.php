<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallesTransferenciaDocumental extends Model
{
    use HasFactory;

    // Table associated with the model
    protected $table = 'detalles_transferencias_documentales';

    // The attributes that are mass assignable
    protected $fillable = [
        'transferencia_id',
        'ubicacion_id',
        'numero_orden',
        'codigo',
        'serie_documental_id',
        'subserie_documental_id',
        'fecha_inicial',
        'fecha_final',
        'caja',
        'carpeta',
        'resolucion',
        'tomo',
        'otro',
        'numero_folios',
        'soporte',
        'frecuencia_consulta',
        'ubicacion_caja',
        'ubicacion_bandeja',
        'ubicacion_estante',
        'observaciones',
        'estado_flujo',
    ];

    // Define the relationship with TransferenciaDocumental
    public function transferencia()
{
    return $this->belongsTo(TransferenciaDocumental::class, 'transferencia_id');
}

    // Define the relationship with Ubicacion
    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class, 'ubicacion_id');
    }

    public function serie()
    { return $this->belongsTo(SerieDocumental::class,'serie_documental_id'); }

    public function subserie()
    { return $this->belongsTo(SubserieDocumental::class,'subserie_documental_id'); }
}
