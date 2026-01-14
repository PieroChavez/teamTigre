<?php

namespace App\Http\Controllers\Tienda;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;

class CarritoController extends Controller
{
    // Ver el contenido del carrito
    public function index()
    {
        $carrito = session()->get('carrito', []);
        $total = 0;
        foreach($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }
        return view('tienda.carrito', compact('carrito', 'total'));
    }

    // Añadir producto al carrito
    public function agregar(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        $carrito = session()->get('carrito', []);

        // Si el producto ya está, aumentamos cantidad
        if(isset($carrito[$id])) {
            $carrito[$id]['cantidad'] += $request->cantidad;
        } else {
            // Si es nuevo, lo añadimos
            $carrito[$id] = [
                "nombre" => $producto->nombre,
                "cantidad" => $request->cantidad,
                "precio" => $producto->precio,
                "imagen" => $producto->imagen_url,
                "talla" => $producto->talla
            ];
        }

        session()->put('carrito', $carrito);
        return redirect()->route('carrito.index')->with('success', 'Producto añadido al carrito');
    }

    // Eliminar un producto
    public function eliminar($id)
    {
        $carrito = session()->get('carrito', []);
        if(isset($carrito[$id])) {
            unset($carrito[$id]);
            session()->put('carrito', $carrito);
        }
        return back()->with('success', 'Producto eliminado');
    }
}