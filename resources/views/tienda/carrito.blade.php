@extends('layouts.public')

@section('title', 'Tu Carrito | Academia Box')

@section('content')
<div class="bg-white min-h-screen">
    <div class="h-24"></div>

    <div class="max-w-7xl mx-auto px-6 py-12">
        <h1 class="text-6xl md:text-8xl font-black uppercase tracking-tighter text-black mb-12">
            Tu Bolsa <span class="text-orange-600">.</span>
        </h1>

        @if(count($carrito) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
                
                {{-- LISTA DE PRODUCTOS (8 Columnas) --}}
                <div class="lg:col-span-8">
                    <div class="space-y-8">
                        @foreach($carrito as $id => $item)
                            <div class="flex items-center gap-6 pb-8 border-b border-gray-100 group">
                                {{-- Imagen --}}
                                <div class="w-32 h-40 bg-[#fbfbfb] rounded-3xl overflow-hidden flex-shrink-0 shadow-sm group-hover:shadow-xl transition-all duration-500">
                                    <img src="{{ $item['imagen'] }}" class="w-full h-full object-cover mix-blend-multiply">
                                </div>

                                {{-- Detalles --}}
                                <div class="flex-1 flex flex-col md:flex-row md:items-center justify-between gap-4">
                                    <div>
                                        <span class="text-[10px] font-black uppercase tracking-widest text-orange-600 mb-1 block">Academia Box Gear</span>
                                        <h3 class="text-2xl font-black uppercase tracking-tight text-black leading-none">{{ $item['nombre'] }}</h3>
                                        <p class="text-gray-400 text-sm font-bold mt-1">Talla: <span class="text-black">{{ $item['talla'] }}</span></p>
                                    </div>

                                    <div class="flex items-center gap-12">
                                        <div class="text-center">
                                            <span class="block text-[9px] font-black uppercase text-gray-300 tracking-widest mb-1">Cantidad</span>
                                            <span class="text-lg font-black text-black">{{ $item['cantidad'] }}</span>
                                        </div>
                                        <div class="text-right">
                                            <span class="block text-[9px] font-black uppercase text-gray-300 tracking-widest mb-1">Subtotal</span>
                                            <span class="text-xl font-black text-black">S/ {{ number_format($item['precio'] * $item['cantidad'], 2) }}</span>
                                        </div>

                                        {{-- Botón Eliminar --}}
                                        <form action="{{ route('carrito.eliminar', $id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-300 hover:text-red-600 transition-colors">
                                                <i class="fa-solid fa-trash-can text-lg"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-12">
                        <a href="{{ route('tienda.index') }}" class="inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-black transition-colors">
                            <i class="fa-solid fa-arrow-left"></i>
                            Continuar comprando
                        </a>
                    </div>
                </div>

                {{-- RESUMEN DE COMPRA (4 Columnas) --}}
                <div class="lg:col-span-4">
                    <div class="bg-gray-50 rounded-[2.5rem] p-10 sticky top-32">
                        <h2 class="text-2xl font-black uppercase mb-8">Resumen <br>del Pedido</h2>
                        
                        <div class="space-y-4 mb-8">
                            <div class="flex justify-between items-center text-sm font-bold">
                                <span class="text-gray-400 uppercase tracking-widest text-[10px]">Subtotal</span>
                                <span class="text-black font-black">S/ {{ number_format($total, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm font-bold">
                                <span class="text-gray-400 uppercase tracking-widest text-[10px]">Envío</span>
                                <span class="text-green-600 font-black italic">Calculado al Checkout</span>
                            </div>
                            <div class="pt-4 border-t border-gray-200 flex justify-between items-end">
                                <span class="text-[10px] font-black uppercase tracking-widest text-black">Total Estimado</span>
                                <span class="text-4xl font-black text-orange-600 leading-none">S/ {{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        {{-- Botón de Pago --}}
                        <div class="space-y-4">
                            {{-- ANTES TENÍAS: href="#" --}}
                                {{-- CÁMBIALO A: --}}
                                <a href="{{ route('tienda.checkout') }}" class="block w-full bg-black text-white text-center py-6 rounded-2xl font-black uppercase tracking-[0.2em] text-xs hover:bg-orange-600 hover:text-black transition-all shadow-xl">
                                    Finalizar Compra
                                </a>
                                                            
                            <p class="text-[9px] text-gray-400 font-medium text-center leading-relaxed">
                                Al proceder al pago, aceptas nuestros términos de servicio y políticas de envío.
                            </p>
                        </div>

                        {{-- Trust Badges --}}
                        <div class="mt-8 pt-8 border-t border-gray-200 flex justify-center gap-6">
                            <i class="fa-brands fa-cc-visa text-2xl text-gray-300"></i>
                            <i class="fa-brands fa-cc-mastercard text-2xl text-gray-300"></i>
                            <i class="fa-solid fa-shield-halved text-2xl text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        @else
            {{-- ESTADO VACÍO --}}
            <div class="py-24 text-center">
                <div class="mb-8">
                    <i class="fa-solid fa-cart-shopping text-8xl text-gray-100"></i>
                </div>
                <h2 class="text-3xl font-black uppercase text-black mb-4">Tu bolsa está vacía</h2>
                <p class="text-gray-400 mb-10 font-medium">Parece que aún no has elegido tu equipo de entrenamiento.</p>
                <a href="{{ route('tienda.index') }}" class="inline-block bg-black text-white px-12 py-5 rounded-2xl font-black uppercase tracking-widest hover:bg-orange-600 transition-all">
                    Explorar Tienda
                </a>
            </div>
        @endif
    </div>
</div>
@endsection