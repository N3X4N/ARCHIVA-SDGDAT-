<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SerieDocumental extends Model
{
    use HasFactory;
    // Especificamos el nombre de la tabla que no sigue la convención de Laravel
    protected $table = 'series_documentales';

    protected $fillable = ['nombre', 'codigo', 'is_active'];

    public function subseriesDocumentales()
    {
        return $this->hasMany(SubserieDocumental::class);
    }
}
