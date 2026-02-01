<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantillaPeriodo extends Model
{
    use HasFactory;

    protected $table = 'plantilla_periodos';

    protected $fillable = [
        'nombre',
        'duracion_meses',
        'duracion_semanas',
        'precio_base',
    ];

    // 🔗 Relaciones
    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class);
    }
}
