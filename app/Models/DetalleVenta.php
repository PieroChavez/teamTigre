<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetalleVenta extends Model
{
    use HasFactory;

    // Especificamos el nombre de la tabla por si Laravel intenta buscar "detalle_ventas"
    protected $table = 'detalle_ventas';

    protected $fillable = [
        'venta_id',       // ID de la venta principal
        'producto_id',    // ID del producto vendido
        'cantidad',       // Cuántas unidades se llevaron
        'precio_unitario',// Precio al que se vendió (importante para historial)
        'subtotal',       // cantidad * precio_unitario
    ];

    /**
     * Relación inversa con la Venta.
     * Cada detalle pertenece a una única venta.
     */
    public function venta(): BelongsTo
    {
        return $this->belongsTo(Venta::class);
    }

    /**
     * Relación con el Producto.
     * Permite saber qué producto se compró: $detalle->producto->nombre
     */
    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }
}