@extends('layouts.public')

@section('title', 'Finalizar Pedido | Academia Box')

@section('content')
<div class="bg-[#f8f8f8] min-h-screen">
    {{-- Espaciador Superior --}}
    <div class="h-28"></div>

    <div class="max-w-7xl mx-auto px-6 py-12">
        {{-- Header de Progreso --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-16 gap-4">
            <div>
                <h1 class="text-5xl md:text-7xl font-black uppercase tracking-tighter text-black leading-none">
                    Casi listo <span class="text-orange-600">.</span>
                </h1>
                <p class="text-gray-400 font-bold uppercase text-[10px] tracking-[0.3em] mt-4">Paso 2 de 2: Información de Entrega</p>
            </div>
            <a href="{{ route('carrito.index') }}" class="group flex items-center gap-3 text-[10px] font-black uppercase tracking-widest text-black hover:text-orange-600 transition-colors">
                <i class="fa-solid fa-arrow-left transition-transform group-hover:-translate-x-2"></i>
                Volver a la bolsa
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            
            {{-- FORMULARIO (Lado Izquierdo) --}}
            <div class="lg:col-span-7 space-y-8">
                
                <form action="{{ route('tienda.confirmar') }}" method="POST" id="checkout-form">
                    @csrf
                    
                    {{-- Bloque 1: Identificación --}}
                    <div class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-[0_20px_50px_rgba(0,0,0,0.02)] border border-gray-100">
                        <div class="flex items-center gap-4 mb-10">
                            <span class="w-10 h-10 rounded-full bg-black text-white flex items-center justify-center font-black text-sm">01</span>
                            <h2 class="text-2xl font-black uppercase tracking-tight">Tus Datos</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="relative group">
                                <label class="text-[9px] font-black uppercase tracking-[0.2em] text-gray-400 absolute -top-2 left-4 bg-white px-2 z-10">Nombre Completo</label>
                                <input type="text" name="nombre" required 
                                    class="w-full bg-white border-2 border-gray-100 rounded-2xl p-5 pt-6 text-sm font-bold focus:border-orange-600 focus:ring-0 transition-all placeholder:text-gray-200"
                                    placeholder="Ej. Juan Pérez">
                            </div>
                            <div class="relative group">
                                <label class="text-[9px] font-black uppercase tracking-[0.2em] text-gray-400 absolute -top-2 left-4 bg-white px-2 z-10">WhatsApp / Celular</label>
                                <input type="text" name="telefono" required 
                                    class="w-full bg-white border-2 border-gray-100 rounded-2xl p-5 pt-6 text-sm font-bold focus:border-orange-600 focus:ring-0 transition-all placeholder:text-gray-200"
                                    placeholder="987 654 321">
                            </div>
                            <div class="relative group md:col-span-2">
                                <label class="text-[9px] font-black uppercase tracking-[0.2em] text-gray-400 absolute -top-2 left-4 bg-white px-2 z-10">Dirección Exacta o Sede de Recojo</label>
                                <input type="text" name="direccion" required 
                                    class="w-full bg-white border-2 border-gray-100 rounded-2xl p-5 pt-6 text-sm font-bold focus:border-orange-600 focus:ring-0 transition-all placeholder:text-gray-200"
                                    placeholder="Av. Las Artes 123 - O 'Recojo en Academia'">
                            </div>
                        </div>
                    </div>

                    {{-- Bloque 2: Pago --}}
                    <div class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-[0_20px_50px_rgba(0,0,0,0.02)] border border-gray-100 mt-8">
                        <div class="flex items-center gap-4 mb-10">
                            <span class="w-10 h-10 rounded-full bg-black text-white flex items-center justify-center font-black text-sm">02</span>
                            <h2 class="text-2xl font-black uppercase tracking-tight">Método de Pago</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            {{-- Yape --}}
                            <label class="cursor-pointer group">
                                <input type="radio" name="metodo_pago" value="yape" class="hidden peer" checked>
                                <div class="h-full p-6 bg-white border-2 border-gray-100 rounded-[2rem] peer-checked:border-orange-600 peer-checked:bg-orange-50/30 transition-all flex flex-col items-center text-center">
                                    <div class="w-14 h-14 bg-gray-50 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                        <i class="fa-solid fa-qrcode text-2xl text-gray-400 group-hover:text-orange-600"></i>
                                    </div>
                                    <span class="font-black uppercase text-[10px] tracking-widest">Yape / Plin</span>
                                </div>
                            </label>

                            {{-- Transferencia --}}
                            <label class="cursor-pointer group">
                                <input type="radio" name="metodo_pago" value="transferencia" class="hidden peer">
                                <div class="h-full p-6 bg-white border-2 border-gray-100 rounded-[2rem] peer-checked:border-orange-600 peer-checked:bg-orange-50/30 transition-all flex flex-col items-center text-center">
                                    <div class="w-14 h-14 bg-gray-50 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                        <i class="fa-solid fa-university text-2xl text-gray-400 group-hover:text-orange-600"></i>
                                    </div>
                                    <span class="font-black uppercase text-[10px] tracking-widest">Transferencia</span>
                                </div>
                            </label>

                            {{-- Efectivo --}}
                            <label class="cursor-pointer group">
                                <input type="radio" name="metodo_pago" value="efectivo" class="hidden peer">
                                <div class="h-full p-6 bg-white border-2 border-gray-100 rounded-[2rem] peer-checked:border-orange-600 peer-checked:bg-orange-50/30 transition-all flex flex-col items-center text-center">
                                    <div class="w-14 h-14 bg-gray-50 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                        <i class="fa-solid fa-hand-holding-dollar text-2xl text-gray-400 group-hover:text-orange-600"></i>
                                    </div>
                                    <span class="font-black uppercase text-[10px] tracking-widest">Pago en Sede</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </form>
            </div>

            {{-- RESUMEN (Lado Derecho) --}}
            <div class="lg:col-span-5 lg:sticky lg:top-32">
                <div class="bg-black rounded-[3rem] p-10 text-white shadow-[0_40px_80px_-15px_rgba(0,0,0,0.3)]">
                    <h3 class="text-xs font-black uppercase tracking-[0.4em] text-orange-600 mb-8 text-center">Resumen de Pedido</h3>
                    
                    <div class="max-h-[300px] overflow-y-auto pr-2 custom-scrollbar space-y-6 mb-8">
                        @foreach($carrito as $item)
                        <div class="flex gap-4">
                            <div class="w-16 h-16 bg-white/5 rounded-xl overflow-hidden flex-shrink-0">
                                <img src="{{ asset('storage/'.$item['imagen']) }}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-black uppercase leading-tight">{{ $item['nombre'] }}</h4>
                                <div class="flex justify-between items-center mt-1">
                                    <span class="text-[10px] text-gray-500 font-bold uppercase">Cant: {{ $item['cantidad'] }}</span>
                                    <span class="text-sm font-bold">S/ {{ number_format($item['precio'] * $item['cantidad'], 2) }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="space-y-4 border-t border-white/10 pt-8">
                        <div class="flex justify-between text-[10px] font-black uppercase tracking-widest text-gray-500">
                            <span>Subtotal</span>
                            <span>S/ {{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-[10px] font-black uppercase tracking-widest text-gray-500">
                            <span>Envío</span>
                            <span class="text-green-500 italic">Por coordinar</span>
                        </div>
                        <div class="flex justify-between items-end pt-4">
                            <span class="text-lg font-black uppercase tracking-tighter">Total</span>
                            <span class="text-5xl font-black text-orange-600 leading-none tracking-tighter">S/ {{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    <button type="submit" form="checkout-form" class="w-full mt-10 group relative overflow-hidden bg-white text-black py-7 rounded-2xl font-black uppercase tracking-[0.2em] text-xs transition-all hover:bg-orange-600 hover:text-white">
                        <span class="relative z-10 flex items-center justify-center gap-3">
                            Confirmar Pedido
                            <i class="fa-brands fa-whatsapp text-lg"></i>
                        </span>
                    </button>
                    
                    <p class="text-[9px] text-gray-500 font-bold text-center mt-6 uppercase tracking-widest">
                        Al confirmar serás redirigido a WhatsApp
                    </p>
                </div>
                
                {{-- Garantía Box --}}
                <div class="mt-8 px-8 flex items-center gap-6">
                    <i class="fa-solid fa-shield-halved text-3xl text-gray-200"></i>
                    <p class="text-[9px] text-gray-400 font-bold uppercase leading-relaxed tracking-widest">
                        Tu compra está protegida. Coordinamos la entrega directamente contigo para máxima seguridad.
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: rgba(255,255,255,0.05); }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
</style>
@endsection