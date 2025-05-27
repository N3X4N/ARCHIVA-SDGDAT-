<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User;
use App\Models\Dependencia;
use App\Models\DetallesTransferenciaDocumental;

class TransferenciaDocumental extends Model
{
    use HasFactory, SoftDeletes;

    // Especifica el nombre de la tabla si no sigue la convención
    protected $table = 'transferencias_documentales';

    // Estados posibles del flujo
    public const ESTADOS = [
        'ELABORADO' => 'Elaborado',
        'ENTREGADO' => 'Entregado',
        'RECIBIDO'  => 'Recibido',
        'ARCHIVADO' => 'Archivado',
    ];

    protected $fillable = [
        'user_id',
        'entidad_remitente_id',
        'entidad_productora_id',
        'oficina_productora_id',
        'unidad_administrativa',
        'registro_entrada',
        'numero_transferencia',
        'objeto',
        'estado_flujo',
        'is_active',
        'elaborado_por',
        'elaborado_fecha',
        'entregado_por',
        'entregado_fecha',
        'recibido_por',
        'recibido_fecha',
    ];

    /**
     * Aquí indicamos qué columnas deben mapearse a Carbon
     */
    protected $casts = [
        'registro_entrada'  => 'datetime',
        'elaborado_fecha'   => 'datetime',
        'entregado_fecha'   => 'datetime',
        'recibido_fecha'    => 'datetime',
        'created_at'        => 'datetime',
        'updated_at'        => 'datetime',
        'deleted_at'        => 'datetime',
    ];


    /** Relaciones básicas */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function entidadRemitente()
    {
        return $this->belongsTo(Dependencia::class, 'entidad_remitente_id');
    }

    public function entidadProductora()
    {
        return $this->belongsTo(Dependencia::class, 'entidad_productora_id');
    }

    public function oficinaProductora()
    {
        return $this->belongsTo(Dependencia::class, 'oficina_productora_id');
    }

    public function detalles()
    {
        // Ajusta 'transferencia_id' al nombre que realmente tienes en tu tabla de detalles
        return $this->hasMany(DetallesTransferenciaDocumental::class, 'transferencia_id')
            ->orderBy('numero_orden', 'asc');
    }

    /** Relaciones de firma */
    public function elaboradoBy()
    {
        return $this->belongsTo(User::class, 'elaborado_por');
    }

    public function entregadoBy()
    {
        return $this->belongsTo(User::class, 'entregado_por');
    }

    public function recibidoBy()
    {
        return $this->belongsTo(User::class, 'recibido_por');
    }

    /** Scopes */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('oficina_productora', 'like', "%{$search}%")
                ->orWhere('numero_transferencia', 'like', "%{$search}%")
                ->orWhere('objeto', 'like', "%{$search}%");
        });
    }
}
