<?php

namespace App\Http\Controllers\Tienda;

use App\Http\Controllers\Controller;
use App\Models\Venta;
use App\Models\DetalleVenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    // Muestra el formulario de datos para el invitado
    public function checkout()
    {
        $carrito = session()->get('carrito', []);
        
        if(empty($carrito)) {
            return redirect()->route('tienda.index')->with('info', 'Tu carrito está vacío');
        }

        $total = array_sum(array_map(fn($item) => $item['precio'] * $item['cantidad'], $carrito));

        return view('tienda.checkout', compact('carrito', 'total'));
    }

    // Procesa la compra, guarda en BD y genera link de WhatsApp
    public function confirmar(Request $request)
    {
        // 1. Validación (Añadimos método_pago)
        $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string',
            'metodo_pago' => 'required|string'
        ]);

        $carrito = session()->get('carrito', []);
        
        if(empty($carrito)) {
            return redirect()->route('tienda.index');
        }

        $total = array_sum(array_map(fn($item) => $item['precio'] * $item['cantidad'], $carrito));
        $urlWhatsapp = "";

        // 2. Transacción Segura
        DB::transaction(function () use ($request, $carrito, $total, &$urlWhatsapp) {
            
            // Crear registro en la tabla 'ventas'
            // IMPORTANTE: Asegúrate de haber corrido la migración de cliente_nombre
            $venta = Venta::create([
                'cliente_nombre' => $request->nombre,
                'telefono'       => $request->telefono,
                'total'          => $total,
                'estado'         => 'Pendiente', 
                'tipo_venta'     => 'Web',       
                'user_id'        => auth()->check() ? auth()->id() : null,
            ]);

            // Crear registros en 'detalle_ventas'
            foreach ($carrito as $id_producto => $item) {
                DetalleVenta::create([
                    'venta_id'        => $venta->id, // ID de la venta recién creada
                    'producto_id'     => $id_producto,
                    'cantidad'        => $item['cantidad'],
                    'precio_unitario' => $item['precio'],
                    'subtotal'        => $item['cantidad'] * $item['precio'],
                ]);
            }

            // 3. Formatear mensaje para WhatsApp (Formato API Directa)
            $mensaje = "🥊 *NUEVO PEDIDO WEB #{$venta->id}*\n\n";
            $mensaje .= "👤 *Cliente:* {$request->nombre}\n";
            $mensaje .= "📞 *Telf:* {$request->telefono}\n";
            $mensaje .= "📍 *Entrega:* {$request->direccion}\n";
            $mensaje .= "💳 *Pago:* " . strtoupper($request->metodo_pago) . "\n\n";
            
            $mensaje .= "📦 *Productos:*\n";
            foreach($carrito as $item) {
                $mensaje .= "- {$item['cantidad']}x {$item['nombre']} (S/ " . number_format($item['precio'], 2) . ")\n";
            }
            
            $mensaje .= "\n💰 *TOTAL: S/ " . number_format($total, 2) . "*\n\n";
            $mensaje .= "_Hola Academia Box, acabo de realizar este pedido desde la web._";

            // El número DEBE llevar el 51 al inicio sin símbolos para que WhatsApp lo acepte
            $phone = "51947637782"; 
            
            // Usamos wa.me que es más compatible y directo que api.whatsapp
            $urlWhatsapp = "https://wa.me/" . $phone . "?text=" . urlencode($mensaje);
        });

        // 4. Limpiar la sesión después del éxito
        session()->forget('carrito');

        // Retornar a una vista de agradecimiento que redireccione automáticamente
        return view('tienda.gracias', compact('urlWhatsapp'));
    }
}