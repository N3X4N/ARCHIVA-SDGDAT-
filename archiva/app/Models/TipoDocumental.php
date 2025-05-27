<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\SerieDocumental;

class TipoDocumental extends Model
{
    use HasFactory, SoftDeletes;

    // Coincide con la migración 'tipos_documentales'
    protected $table = 'tipos_documentales';
    protected $fillable = ['nombre', 'is_active'];

    /**
     * Series asociadas (muchos a muchos).
     */
    public function seriesDocumentales()
    {
        return $this->belongsToMany(
            SerieDocumental::class,
            'tipo_documental_serie',
            'tipo_documental_id',
            'serie_documental_id'
        )->withTimestamps();
    }
}
