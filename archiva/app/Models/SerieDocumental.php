<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SerieDocumental extends Model
{
    use HasFactory, SoftDeletes;

    // Nombre explícito de la tabla
    protected $table = 'series_documentales';

    // Campos rellenables
    protected $fillable = [
        'serie_padre_id',
        'codigo',
        'nombre',
        'observaciones',
        'is_active',
    ];

    /**
     * Relación con subseries
     */
    public function subseries()
    {
        return $this->hasMany(SubserieDocumental::class, 'serie_documental_id');
    }

    /**
     * Relación con la serie padre (jerarquía)
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'serie_padre_id');
    }

    /**
     * Relación muchos a muchos con Tipos Documentales.
     */
    public function tiposDocumentales()
    {
        return $this->belongsToMany(
            TipoDocumental::class,
            'tipo_documental_serie',
            'serie_documental_id',
            'tipo_documental_id'
        )->withTimestamps();
    }
}
