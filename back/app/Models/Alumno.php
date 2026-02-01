<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Alumno extends Model
{
    use HasFactory;

    protected $table = 'alumnos';

    protected $fillable = [
        'user_id',
        'codigo_barra',
        'fecha_ingreso',
        'estado',
    ];

    protected $casts = [
        'fecha_ingreso' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // --- Relaciones ---

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function inscripciones(): HasMany
    {
        return $this->hasMany(Inscripcion::class);
    }

    // ⭐ RELACIÓN CORREGIDA: Usamos HasManyThrough para pasar por la tabla 'inscripciones'
    // El Alumno no tiene la clave en 'cuentas_inscripcion', por lo que debemos ir por 'inscripciones'.
    public function cuentasInscripcion(): HasManyThrough
    {
        return $this->hasManyThrough(
            CuentaInscripcion::class, // Modelo final (El que queremos)
            Inscripcion::class,       // Modelo intermedio (Por donde pasamos)
            'alumno_id',              // Clave foránea de Alumno en la tabla 'inscripciones'
            'inscripcion_id',         // Clave foránea de Inscripcion en la tabla 'cuentas_inscripcion'
            'id',                     // Clave local de Alumno
            'id'                      // Clave local de Inscripcion
        );
    }

    // ⭐ RELACIÓN AÑADIDA: Acceso a todas las LÍNEAS DE DEUDA/CUOTAS del alumno
    // Usamos hasManyThrough: Alumno -> Inscripcion -> CuentaInscripcion -> CuotaPago
    // NOTA: Esta relación es un HAS MANY THROUGH a TRES niveles, que no está soportado nativamente en Laravel.
    // La relación original que definiste es incorrecta porque salta la tabla 'inscripciones':
    /*
    public function cuotaPagos(): HasManyThrough
    {
        return $this->hasManyThrough(
            CuotaPago::class,           // Modelo final
            CuentaInscripcion::class,   // Modelo intermedio INCORRECTO (debe ser Inscripcion)
            'alumno_id',                // Clave foránea INCORRECTA
            'cuenta_inscripcion_id',    // Clave foránea correcta
        );
    }
    */
    
    // Deberías usar el método 'pagos()' que creaste, que es más lento pero funcional, 
    // o reestructurar tus relaciones a través de la Colección.
    
    // ✅ Acceso a todos los pagos del alumno mediante colecciones (manteniendo tu método original)
    // Este método es más lento, pero funcional si las relaciones intermedias son complejas.
    public function pagos()
    {
        // Forzamos la consulta a la DB
        // Usamos la relación CORREGIDA 'cuentasInscripcion' aquí:
        $cuentasConPagos = $this->cuentasInscripcion()->with('cuotas.pagos')->get();
        
        return $cuentasConPagos
            ->flatMap(fn($cuenta) => $cuenta->cuotas->flatMap(fn($cuota) => $cuota->pagos))
            ->sortByDesc('fecha_pago');
    }

    
}