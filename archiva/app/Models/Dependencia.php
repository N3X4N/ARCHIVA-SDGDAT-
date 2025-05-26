<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Dependencia extends Model
{
    use HasFactory,  SoftDeletes;

    protected $fillable = ['nombre', 'sigla', 'codigo', 'is_active'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }


    public function transferencias()
    {
        return $this->hasMany(TransferenciaDocumental::class, 'entidad_remitente_id', 'id');
    }


    public function users()
    {
        return $this->hasMany(\App\Models\User::class, 'dependencia_id');
    }


    public function subseries()
    {
        return $this->belongsToMany(
            \App\Models\SubserieDocumental::class,
            'dependencia_subserie',
            'dependencia_id',
            'subserie_documental_id'
        );
    }
}
