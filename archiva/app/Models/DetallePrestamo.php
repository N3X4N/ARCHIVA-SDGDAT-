<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Prestamo;
use App\Models\DetallesTransferenciaDocumental;
use App\Models\Ubicacion;


class DetallePrestamo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'detalles_prestamo';

    protected $fillable = [
        'prestamo_id',
        'transferencia_documental_id',
        'ubicacion_id',
        'cantidad',
        'fecha_entregado',
        'observaciones',
        'is_active',
    ];

    // Relación al préstamo padre
    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class, 'prestamo_id');
    }

    // Relación al detalle original de transferencia
    public function detalleTransferencia()
    {
        return $this->belongsTo(
            DetallesTransferenciaDocumental::class,
            'transferencia_documental_id'
        );
    }

    // Relación a la ubicación
    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class, 'ubicacion_id');
    }
}
