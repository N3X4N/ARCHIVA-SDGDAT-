<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\DetallesTransferenciaDocumental;

class Soporte extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion', 'is_active'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function detallesTransferencias()
    {
        return $this->hasMany(DetallesTransferenciaDocumental::class, 'soporte_id');
    }
}
