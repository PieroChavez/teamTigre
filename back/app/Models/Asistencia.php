<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $fillable = [
        'inscripcion_id',
        'fecha',
        'hora_ingreso',
        'metodo',
    ];

    protected $casts = [
        'fecha' => 'date',
        'hora_ingreso' => 'datetime:H:i:s',
    ];

    public function inscripcion()
    {
        return $this->belongsTo(Inscripcion::class);
    }

    public function alumno()
    {
        return $this->inscripcion->alumno();
    }
}
