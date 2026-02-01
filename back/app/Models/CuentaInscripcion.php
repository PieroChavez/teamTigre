<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Casts\Attribute; // Para el Accessor

class CuentaInscripcion extends Model
{
    use HasFactory;

    protected $table = 'cuentas_inscripcion';

    protected $fillable = [
        'inscripcion_id',
        'concepto_pago_id',
        'monto_total',
        'descuento',
        'monto_final',
        'estado',
    ];

    protected $casts = [
        'monto_total' => 'float',
        'descuento' => 'float',
        'monto_final' => 'float',
    ];

    // --------------------------------------------------------------------------
    // | RELACIONES
    // --------------------------------------------------------------------------

    /**
     * La Cuenta de Inscripción pertenece a una Inscripción.
     * @return BelongsTo
     */
    public function inscripcion(): BelongsTo
    {
        return $this->belongsTo(Inscripcion::class, 'inscripcion_id');
    }

    /**
     * La Cuenta de Inscripción tiene un Concepto de Pago asociado (plan de cuotas).
     * @return BelongsTo
     */
    public function conceptoPago(): BelongsTo
    {
        return $this->belongsTo(ConceptoPago::class, 'concepto_pago_id');
    }

    /**
     * Una Cuenta de Inscripción tiene muchas Cuotas de Pago (la deuda real).
     * @return HasMany
     */
    public function cuotas(): HasMany
    {
        return $this->hasMany(CuotaPago::class, 'cuenta_inscripcion_id');
    }
    
    // --------------------------------------------------------------------------
    // | ⭐ RELACIÓN HAS ONE THROUGH (Acceso al Alumno)
    // --------------------------------------------------------------------------

    /**
     * Obtiene el Alumno a través de la Inscripción.
     * Esto permite usar $cuentaInscripcion->alumno en lugar de $cuentaInscripcion->inscripcion->alumno
     *
     * @return HasOneThrough
     */
    public function alumno(): HasOneThrough
    {
        return $this->hasOneThrough(
            Alumno::class,          // Modelo final que queremos obtener (Alumno)
            Inscripcion::class,     // Modelo intermedio (Inscripcion)
            'id',                   // Clave de la tabla intermedia (Inscripcion.id)
            'id',                   // Clave de la tabla final (Alumno.id)
            'inscripcion_id',       // Clave local en CuentaInscripcion
            'alumno_id'             // Clave en Inscripcion que conecta con Alumno
        );
    }
    
    // --------------------------------------------------------------------------
    // | ACCESORES (Funciones de Ayuda)
    // --------------------------------------------------------------------------

    /**
     * ACCESOR: Calcula y devuelve el monto total pagado para esta Cuenta de Inscripción.
     * Esto simplifica la lógica en las vistas.
     *
     * @return Attribute
     */
    protected function montoPagadoTotal(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->cuotas->sum('monto_pagado_total'),
        );
    }

    /**
     * ACCESOR: Calcula y devuelve el monto total pendiente de pago para esta Cuenta de Inscripción.
     *
     * @return Attribute
     */
    protected function montoPendienteTotal(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->cuotas->sum('monto_pendiente'),
        );
    }
}