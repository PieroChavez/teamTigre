<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'edad_min',
        'edad_max'
    ];

    // Una categoría tiene muchos alumnos
    public function alumnos()
    {
        return $this->hasMany(Alumno::class);
    }
}
