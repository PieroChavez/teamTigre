<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialPago extends Model
{
    use HasFactory;

    protected $fillable = [
        'pago_id',
        'user_id',
        'accion',
        'detalle',
    ];

    public function pago()
    {
        return $this->belongsTo(Pago::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
