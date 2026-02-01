<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;

class CoachProfile extends Model
{
    // =========================================================
    // ✅ 1. PROPIEDADES PRINCIPALES
    // =========================================================

    /**
     * Los atributos que son asignables masivamente (Mass Assignable).
     * Incluye el campo 'birth_date' que agregamos.
     * * NOTA: 'bio' y 'experience_years' no están en tu tabla, pero si los mapeas
     * a 'notes' y 'specialty' en el controlador, ¡deben ser revisados!
     * * Basado en las columnas que tienes (dni, phone, specialty, status, notes):
     */
    protected $fillable = [
        'user_id',
        'dni',
        'phone', 
        'birth_date', // <-- AGREGADO: Asegura que se pueda asignar masivamente
        'specialty', 
        'status',
        'notes', // Usado para 'bio' en el controlador
        // 'experience_years' y 'bio' del código original no están en la BD o son mapeados 
        // a 'specialty' y 'notes', por lo que los he ajustado a los campos reales.
    ];

    /**
     * Los atributos que deben ser casteados a tipos nativos.
     * Esto es crucial para que Carbon funcione bien en la vista.
     */
    protected $casts = [
        'birth_date' => 'date', // <-- AGREGADO: Castea la columna a un objeto Carbon
    ];


    // =========================================================
    // ✅ 2. RELACIONES
    // =========================================================

    /**
     * Un perfil de coach pertenece a un usuario (User).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Un perfil de coach tiene muchas categorías a cargo (Many-to-Many).
     */
    public function categories() 
    {
        return $this->belongsToMany(
            Category::class,
            'category_coach',
            'coach_profile_id', // Clave foránea local en la tabla pivote
            'category_id'      // Clave foránea relacionada en la tabla pivote
        );
    }
}