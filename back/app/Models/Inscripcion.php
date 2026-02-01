<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inscripcion extends Model
{
    use HasFactory;
    
    protected $table = 'inscripciones';

    protected $fillable = [
        'alumno_id',
        'categoria_id',
        'plantilla_periodo_id',
        'horario_id',
        'fecha_inicio',
        'fecha_fin',
        'semanas_reales',
        'estado',
    ];

    protected $casts = [
        'fecha_inicio' => 'datetime', 
        'fecha_fin' => 'datetime',
    ];

    // ==============================
    // Relaciones Eloquent
    // ==============================
    
    public function alumno(): BelongsTo
    {
        return $this->belongsTo(Alumno::class);
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function periodo(): BelongsTo
    {
        return $this->belongsTo(PlantillaPeriodo::class, 'plantilla_periodo_id');
    }

    public function horario(): BelongsTo
    {
        return $this->belongsTo(Horario::class);
    }

    /**
     * Relación con la cuenta de deuda asociada a esta inscripción.
     * ⚠️ CORRECCIÓN: Renombrada de 'cuentas' a 'cuentasInscripcion' para coincidir 
     * con la carga anidada en AlumnoController@show ('inscripciones.cuentasInscripcion').
     */
    public function cuentasInscripcion(): HasMany
    {
        return $this->hasMany(CuentaInscripcion::class);
    }

    /**
     * Registros de asistencia de esta inscripción.
     */
    public function asistencias(): HasMany
    {
        // ⚠️ Nota: Asume que la tabla 'asistencias' tiene una FK 'inscripcion_id'.
        return $this->hasMany(Asistencia::class);
    }
}