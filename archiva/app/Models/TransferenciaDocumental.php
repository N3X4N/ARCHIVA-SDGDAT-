<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Dependencia;
use App\Models\SerieDocumental;
use App\Models\SubserieDocumental;
use App\Models\Ubicacion;
use App\Models\Soporte;
use App\Models\DetallesTransferenciaDocumental;

class TransferenciaDocumental extends Model
{
    use HasFactory;

    // Especifica el nombre de la tabla si no sigue la convención
    protected $table = 'transferencias_documentales';

    protected $fillable = [
        'user_id',
        'dependencia_id',
        'ubicacion_id',
        'entidad_productora',
        'unidad_administrativa',
        'oficina_productora',
        'registro_entrada',
        'numero_transferencia',
        'objeto',
        'estado_flujo',
        'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class);
    }

    public function serieDocumental()
    {
        return $this->belongsTo(SerieDocumental::class, 'serie_documental_id');
    }

    public function subserieDocumental()
    {
        return $this->belongsTo(SubserieDocumental::class);
    }

    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class);
    }

    public function soporte()
    {
        return $this->belongsTo(Soporte::class);
    }

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
            $q->where('oficina_productora', 'like', "%$search%")
                ->orWhere('numero_transferencia', 'like', "%$search%")
                ->orWhere('objeto', 'like', "%$search%")
                ->orWhere('numero_orden', 'like', "%$search%")
                ->orWhere('codigo_interno', 'like', "%$search%");
        });
    }
    public function detalles()
    {
        return $this->hasMany(DetallesTransferenciaDocumental::class, 'transferencia_id');
    }
}
