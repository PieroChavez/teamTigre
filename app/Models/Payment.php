<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory; // Asumo que usas HasFactory, aunque no estaba en el snippet original

    protected $fillable = [
        'enrollment_id',
        'plan_id',      // <--- ✅ CORRECCIÓN APLICADA AQUÍ
        'amount',
        'method',
        'status',
        'reference',
        'paid_at',
        'notes',        // <-- Asumo que 'notes' también debería estar si se usa en el controlador
    ];


    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function plan()
    {
        // Asegúrate de que Plan::class esté correctamente importado o definido en el mismo namespace si no es global.
        return $this->belongsTo(Plan::class);
    }

}