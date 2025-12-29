<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Añadido si usas factories

class StudentProfile extends Model
{
    // Si estás usando Factories, descomenta la siguiente línea
    use HasFactory; 

    protected $fillable = [
        'user_id',
        'dni',
        'code',
        'phone',
        'photo', // <--- ¡CAMBIO CLAVE AÑADIDO AQUÍ!
        'birth_date',
        'gender',
        'emergency_contact',
        'joined_at',
        'status',
        'notes',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}