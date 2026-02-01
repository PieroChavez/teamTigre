<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pago extends Model
{
    use HasFactory;

    protected $table = 'pagos';

    /**
     * Campos que se pueden llenar masivamente
     */
    protected $fillable = [
        'cuota_pago_id',   // Relación con la cuota que se está pagando
        'tipo_pago_id',    // Tipo de pago (efectivo, tarjeta, transferencia, etc.)
        'monto',           // Monto del pago
        'fecha_pago',      // Fecha del pago
        'referencia',      // Referencia externa (opcional)
        'usuario_id',      // Usuario que registró el pago (cajero/admin) ✅
        'estado',          // Estado del pago (si la columna existe en la tabla)
    ];

    /**
     * Conversión automática de campos a tipos específicos
     */
    protected $casts = [
        'fecha_pago' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'monto' => 'decimal:2', 
    ];

    // ========================
    // Relaciones Eloquent
    // ========================

    public function cuotaPago(): BelongsTo
    {
        return $this->belongsTo(CuotaPago::class, 'cuota_pago_id');
    }

    public function tipoPago(): BelongsTo
    {
        return $this->belongsTo(TipoPago::class, 'tipo_pago_id');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id'); // ✅ Relación con quien registró el pago
    }
}
