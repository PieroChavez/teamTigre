<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class CuotaPago extends Model
{
    use HasFactory;

    protected $table = 'cuota_pagos';

    protected $fillable = [
        'cuenta_inscripcion_id',
        'tipo_pago_id',
        'monto',
        'concepto',
        'fecha_programada',
        'fecha_pago',
        'estado',
    ];

    protected $casts = [
        'fecha_programada' => 'datetime',
        'fecha_pago' => 'datetime',
        'monto' => 'decimal:2',
        // 'monto_pagado' => 'decimal:2', // Se puede comentar si no existe en DB, ya que el Accessor lo gestiona.
    ];

    // =====================
    // RELACIONES
    // =====================

    public function cuentaInscripcion(): BelongsTo
    {
        return $this->belongsTo(CuentaInscripcion::class);
    }

    public function tipoPago(): BelongsTo
    {
        return $this->belongsTo(TipoPago::class);
    }

    /**
     * Define la relación con los pagos realizados para esta cuota.
     * 💡 CORRECCIÓN: Los pagos se cargan ORDENADOS del más reciente al más antiguo.
     */
    public function pagos(): HasMany
{
    return $this->hasMany(Pago::class, 'cuota_pago_id')
        ->orderByDesc('created_at');
}

    // =====================
    // ACCESORES FINANCIEROS
    // =====================

    protected function montoPagadoTotal(): Attribute
    {
        return Attribute::make(
            get: fn () => (float) $this->pagos->sum('monto'),
        );
    }

    protected function montoPendiente(): Attribute
    {
        return Attribute::make(
            get: fn () => max(0, $this->monto - $this->monto_pagado_total),
        );
    }
    
    protected function porcentajePagado(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->monto > 0
                ? (int) round(($this->monto_pagado_total / $this->monto) * 100)
                : 0,
        );
    }

    protected function estaVencida(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->estado === 'pendiente'
                && $this->fecha_programada
                && $this->fecha_programada->isPast(),
        );
    }
}