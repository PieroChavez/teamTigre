<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ConceptoPago extends Model
{
    use HasFactory;
    
    // 🔹 Indicar explícitamente el nombre correcto de la tabla (Correcto)
    protected $table = 'conceptos_pago'; 
    
    protected $fillable = [
        // 🛠️ CORRECCIÓN: 'nombre' debe estar en $fillable para que los seeders/actualizaciones funcionen
        'nombre', 
        
        // Campos que definen el precio y el tipo
        'monto_base',
        'es_inscripcion', 
        
        // 🔹 CAMPOS CRUCIALES AÑADIDOS PARA LA GENERACIÓN DE CUOTAS
        'num_cuotas',
        'frecuencia_dias', 
        
        // 💡 Sugerencia: Añadir 'descripcion' si existe en la migración
        'descripcion', 
    ];

    /**
     * Casts para asegurar que los números sean tratados como enteros.
     */
    protected $casts = [
        'monto_base' => 'decimal:2',
        'es_inscripcion' => 'boolean',
        'num_cuotas' => 'integer',
        'frecuencia_dias' => 'integer',
        // Si tienes 'descripcion', no necesita cast
    ];

    /**
     * Un concepto de pago puede tener muchas cuentas de inscripción asociadas.
     */
    public function cuentasInscripcion(): HasMany
    {
        return $this->hasMany(CuentaInscripcion::class);
    }
}