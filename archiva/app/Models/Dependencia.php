<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dependencia extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'sigla', 'codigo', 'is_active'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }


    public function transferencias()
    {
        return $this->hasMany(\App\Models\TransferenciaDocumental::class, 'dependencia_id');
    }
}
