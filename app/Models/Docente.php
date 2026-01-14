<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'dni',        // ¡Debe estar aquí!
        'telefono',   // ¡Debe estar aquí!
        'especialidad',
        'experiencia', // Columna de tu migración original
        'estado',     // ¡Debe estar aquí!
    ];

    /**
     * Relación con el usuario asociado para el login
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function horarios()
    {
        // Esto asume que la tabla 'horarios' tiene una clave foránea 'docente_id'.
        return $this->hasMany(Horario::class);
    }
}