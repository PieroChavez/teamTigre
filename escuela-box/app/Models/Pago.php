<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pago extends Model
{
    use HasFactory, SoftDeletes; // habilita SoftDeletes

    protected $fillable = [
        'alumno_id',
        'monto',
        'fecha_pago',
        'concepto',
        'estado', // nuevo campo
    ];

    protected $casts = [
        'fecha_pago' => 'date', // permite usar ->format() directamente
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    // Relación con historial de pagos
    public function historial()
    {
        return $this->hasMany(HistorialPago::class);
    }
}
