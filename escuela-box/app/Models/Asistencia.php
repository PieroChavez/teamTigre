<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'alumno_id',
        'fecha',
        'presente'
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }
}
