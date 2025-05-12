<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'nombre_rol',
        'is_active',
        'description',
    ];

    // Relación con User (un rol puede tener muchos usuarios)
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
