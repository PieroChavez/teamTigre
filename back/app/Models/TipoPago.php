<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoPago extends Model
{
    use HasFactory;

    protected $table = 'tipos_pago';
    
    // Los modelos de catálogo (tipos, estados) usualmente no necesitan marcas de tiempo
    public $timestamps = false; 

    protected $fillable = [
        'nombre',
    ];

    /**
     * Relación: Un TipoPago puede ser usado en muchas Transacciones de Pago (Pago).
     * Esta es la relación CRUCIAL que permite mostrar el método en el historial.
     */
    public function pagos(): HasMany
    {
        // El FK 'tipo_pago_id' existe en la tabla 'pagos'
        return $this->hasMany(Pago::class, 'tipo_pago_id');
    }

    // Eliminamos 'protected $with = [...]' para evitar carga excesiva.
    // Eliminamos la relación 'cuotasPago()' para mantener el esquema limpio, 
    // ya que el TipoPago se relaciona con la transacción (Pago), no con la deuda (CuotaPago).
}