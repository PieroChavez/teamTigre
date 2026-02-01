<?php

namespace App\Http\Controllers\Tienda;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;

class PublicProductoController extends Controller
{
    /**
     * Muestra la tienda pública a los clientes.
     */
    public function index(Request $request)
    {
        // Traemos los productos con stock y permitimos búsqueda
        $productos = Producto::query()
            ->when($request->search, function($query, $search) {
                $query->where('nombre', 'like', "%{$search}%");
            })
            ->get();

        return view('tienda.productos.index', compact('productos'));
    }

    /**
     * (Opcional) Para ver el detalle de un solo producto más adelante
     */
    public function show($id)
    {
        $producto = Producto::findOrFail($id);
        return view('tienda.productos.show', compact('producto'));
    }
}