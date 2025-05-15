<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDocumentalSerie extends Model
{
    use HasFactory;

    protected $table = 'tipo_documental_serie';
    protected $fillable = ['tipo_documental_id', 'serie_documental_id'];

    public function tipoDocumental()
    {
        return $this->belongsTo(TipoDocumental::class, 'tipo_documental_id');
    }

    public function serieDocumental()
    {
        return $this->belongsTo(SerieDocumental::class, 'serie_documental_id');
    }
}
