<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// Importaciones de Modelos
use App\Models\Role;
use App\Models\Enrollment;
use App\Models\StudentProfile; // 💡 Importación requerida para la nueva relación
use App\Models\CoachProfile;   // 💡 Importación requerida para la nueva relación
use App\Models\Category;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        // Mantener solo campos de usuario (autenticación y rol)
        'name',
        'email',
        'password',
        'role_id', // Asumo que tienes role_id en fillable
        // DNI, phone, status deberían ser movidos al perfil si usas perfiles.
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relación al Rol (Uno a Uno)
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // -----------------------------------------------------------
    // 🎯 RELACIONES DE PERFILES (UNO A UNO)
    // -----------------------------------------------------------

    // 1. Perfil del ALUMNO (¡La que faltaba!)
    // Un Usuario (si es alumno) tiene un Perfil de Estudiante.
    public function studentProfile()
    {
        return $this->hasOne(StudentProfile::class);
    }

    // 2. Perfil del COACH
    // Un Usuario (si es coach) tiene un Perfil de Coach.
    public function coachProfile()
    {
        return $this->hasOne(CoachProfile::class);
    }
    
    // -----------------------------------------------------------
    // 🔗 ACCESOS VÍA PERFIL (RELACIONES CONVENIENTES)
    // -----------------------------------------------------------

    // Relación Muchos a Muchos (Para el rol de COACH): 
    // Acceso a las categorías entrenadas VÍA CoachProfile.
    // 🎯 CATEGORÍAS ASIGNADAS AL COACH
    public function coachedCategories()
    {
        return Category::whereHas('coaches', function ($query) {
            $query->where('coach_profiles.user_id', $this->id);
        });
    }



    // Relación Uno a Muchos (Para el rol de ALUMNO): 
    // Acceso a las inscripciones VÍA StudentProfile.
    public function enrollments()
    {
        // El acceso es a través del perfil del alumno.
        // Si tienes una relación hasManyThrough, es más directo,
        // pero lo haremos apuntando a la relación de StudentProfile.
        return $this->studentProfile->enrollments(); 
        
        /* // Alternativa hasManyThrough si deseas saltar el perfil:
        return $this->hasManyThrough(
            Enrollment::class, 
            StudentProfile::class, 
            'user_id',            // Clave foránea en StudentProfile
            'student_profile_id', // Clave foránea en Enrollment
            'id',                 // Clave local en User
            'id'                  // Clave local en StudentProfile
        );
        */
    }
}