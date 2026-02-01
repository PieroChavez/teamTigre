<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_nombre', // Nombre del invitado o cliente web
        'telefono',       // Teléfono de contacto
        'total',          // Monto total de la venta
        'estado',         // Pendiente, Pagado, Cancelado
        'tipo_venta',     // Web o Presencial
        'user_id',        // ID del usuario si está registrado (nullable)
    ];

    /**
     * Relación con los detalles de la venta.
     * Una venta tiene muchos productos asociados.
     */
    public function detalles(): HasMany
    {
        return $this->hasMany(DetalleVenta::class);
    }

    /**
     * Relación con el usuario (Alumno/Admin).
     * Una venta puede pertenecer a un usuario registrado.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Atributo para obtener el nombre del cliente sin importar si es invitado o usuario.
     * Útil para mostrar en tablas de administración: $venta->nombre_final
     */
    public function getNombreFinalAttribute(): string
    {
        if ($this->cliente_nombre) {
            return $this->cliente_nombre;
        }
        
        return $this->user ? $this->user->name : 'Cliente Anónimo';
    }

    /**
     * Scope para filtrar ventas realizadas por la Web.
     * Uso: Venta::soloWeb()->get();
     */
    public function scopeSoloWeb($query)
    {
        return $query->where('tipo_venta', 'Web');
    }
}