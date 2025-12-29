<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Enrollment; 
use App\Models\User; 
use App\Models\Plan;
// Si tienes un modelo CoachProfile
use App\Models\CoachProfile; // Asegúrate de que esta línea esté descomentada si usas la relación

class Category extends Model
{
    // Corregido: Solo incluimos los campos que SÍ existen en la tabla de la DB.
    // 'description' y 'user_id' se eliminan ya que causaron el error 'Unknown column'.
    protected $fillable = [
        'name',
        'level', 
        'type',
        'active',
        'status', // Asumimos que 'status' SÍ existe si no causó error de 'Unknown column'
    ];

    // Relación Muchos a Muchos: Una categoría puede tener muchos coaches (usuarios).
    public function coaches()
    {
        return $this->belongsToMany(
            CoachProfile::class, 
            'category_coach', 
            'category_id', 
            'coach_profile_id'
        );
    }

    // Relación Uno a Muchos: Una categoría tiene muchos Planes de precios.
    public function plans()
    {
        return $this->hasMany(Plan::class);
    }
    
    // Relación Uno a Muchos: Una categoría puede tener muchas inscripciones.
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}