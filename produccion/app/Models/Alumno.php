<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Evento;


class Alumno extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellido',
        'fecha_nacimiento',
        'categoria_id',
        'foto'
    ];

    // Alumno pertenece a una categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    // Alumno tiene muchas asistencias
    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }

    // Alumno tiene muchos pagos
    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    // Alumno participa en muchos eventos
    public function eventos()
    {
        return $this->belongsToMany(Evento::class, 'evento_alumno');
    }

    public function pagoDelMes()
    {
        return $this->pagos()
            ->whereMonth('fecha_pago', Carbon::now()->month)
            ->whereYear('fecha_pago', Carbon::now()->year)
            ->exists();
    }

    

    
}
