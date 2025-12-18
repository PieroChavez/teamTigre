<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'fecha', 
        'descripcion',
        'costo', // AÑADIDO: Para permitir la asignación masiva del costo en el controlador
    ];
    
    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'fecha' => 'date', // AÑADIDO: Convierte el campo 'fecha' de string a objeto Carbon (DateTime)
    ];

    public function alumnos()
    {
        return $this->belongsToMany(Alumno::class, 'evento_alumno');
    }
}