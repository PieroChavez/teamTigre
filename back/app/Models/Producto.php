<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    // Asegúrate de que los campos coincidan con tu base de datos
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'color',
        'talla',
        'genero', // varon, mujer, unisex
        'imagen_url',
        'categoria_producto_id'
    ];
}