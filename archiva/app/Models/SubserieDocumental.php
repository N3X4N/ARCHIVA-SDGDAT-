<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubserieDocumental extends Model
{
    use HasFactory;

    // Especificamos el nombre correcto de la tabla
    protected $table = 'subseries_documentales';

    protected $fillable = ['nombre', 'codigo', 'serie_documental_id', 'is_active'];

    public function serieDocumental()
    {
        return $this->belongsTo(SerieDocumental::class);
    }
}
