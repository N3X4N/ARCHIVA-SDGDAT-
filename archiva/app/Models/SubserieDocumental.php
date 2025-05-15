<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\SeriesDocumental;

class SubserieDocumental extends Model
{
    use SoftDeletes;

    protected $table = 'subseries_documentales';

    protected $fillable = [
        'serie_documental_id',
        'codigo',
        'nombre',
        'is_active',
    ];

    public function serie()
    {
        return $this->belongsTo(SerieDocumental::class, 'serie_documental_id');
    }

    public function detallesTransferencias()
    {
        return $this->hasMany(DetallesTransferenciaDocumental::class, 'subserie_documental_id');
    }

    public function dependencias()
    {
        return $this->belongsToMany(
            \App\Models\Dependencia::class,
            'dependencia_subserie',
            'subserie_documental_id',
            'dependencia_id'
        );
    }
}
