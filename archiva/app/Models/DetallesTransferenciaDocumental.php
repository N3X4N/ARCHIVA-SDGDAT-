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
        'id',
        'transferencia_id',
        'ubicacion_id',
        'numero_orden',
        'codigo',
        'nombre_series_subserie',
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
}
