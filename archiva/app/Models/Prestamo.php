<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Prestamo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'prestamos';

    protected $fillable = [
        'user_id_solicitante',
        'user_id_receptor',
        'fecha_prestamo',
        'fecha_vencimiento',
        'fecha_devolucion',
        'estado',
        'firma_solicitante', 
        'firma_receptor',    
        'observaciones',
        'is_active',
    ];

    protected $casts = [
        'fecha_prestamo' => 'datetime',
        'fecha_vencimiento' => 'datetime',
        'fecha_devolucion' => 'datetime',
        'is_active' => 'boolean',
    ];

    // --- Relaciones ---
    public function solicitante()
    {
        return $this->belongsTo(User::class, 'user_id_solicitante');
    }

    public function receptor()
    {
        return $this->belongsTo(User::class, 'user_id_receptor');
    }

    // --- Atributos Adicionales (Accessors) ---
    public function getFechaPrestamoFormattedAttribute()
    {
        return $this->fecha_prestamo ? Carbon::parse($this->fecha_prestamo)->format('d/m/Y H:i') : 'N/A';
    }

    public function getFechaVencimientoFormattedAttribute()
    {
        return $this->fecha_vencimiento ? Carbon::parse($this->fecha_vencimiento)->format('d/m/Y H:i') : 'N/A';
    }

    public function getFechaDevolucionFormattedAttribute()
    {
        return $this->fecha_devolucion ? Carbon::parse($this->fecha_devolucion)->format('d/m/Y H:i') : 'N/A';
    }

    // --- Scopes (Ejemplo) ---
    public function scopeActivos($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePendientes($query)
    {
        return $query->where('estado', 'prestado');
    }
}
