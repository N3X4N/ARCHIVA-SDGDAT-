<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetallesTransferenciaDocumental extends Model
{
    use HasFactory, SoftDeletes;

    // Table associated with the model
    protected $table = 'detalles_transferencias_documentales';

    // The attributes that are mass assignable
    protected $fillable = [
        'transferencia_id',
        'ubicacion_id',
        'serie_documental_id',
        'subserie_documental_id',
        'fecha_inicial',
        'fecha_final',
        'numero_orden',
        'codigo',
        'caja',
        'carpeta',
        'resolucion',
        'tomo',
        'otro',
        'numero_folios',
        'frecuencia_consulta',
        'observaciones',
        'estado_flujo',
        'soporte_id',            // <-- ahora FK
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
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
    {
        return $this->belongsTo(SerieDocumental::class, 'serie_documental_id');
    }

    public function subserie()
    {
        return $this->belongsTo(SubserieDocumental::class, 'subserie_documental_id');
    }

    public function soporte()
    {
        return $this->belongsTo(Soporte::class);
    }
}
