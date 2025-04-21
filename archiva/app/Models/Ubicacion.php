<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    use HasFactory;

    // Especificamos el nombre correcto de la tabla
    protected $table = 'ubicaciones';  // Asegúrate de que este sea el nombre correcto de la tabla

    protected $fillable = ['estante', 'bandeja', 'caja', 'carpeta', 'otro', 'is_active'];
}
