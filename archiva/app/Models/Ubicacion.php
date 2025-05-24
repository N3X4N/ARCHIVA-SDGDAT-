<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\DetallesTransferenciaDocumental; // modelo en singular

class Ubicacion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ubicaciones';

    protected $fillable = [
        'estante',
        'bandeja',
        'caja',
        'carpeta',
        'otro',
        'is_active',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Relación uno a muchos con el detalle de transferencias.
     * Asume que en la tabla detalles_transferencia_documental
     * la FK se llama ubicacion_id.
     */
    public function detallesTransferencias()
    {
        return $this->hasMany(DetallesTransferenciaDocumental::class, 'ubicacion_id');
    }
}
