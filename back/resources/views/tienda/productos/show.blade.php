@extends('layouts.public')

@section('title', $producto->nombre . ' | Academia Box')

@section('content')
<div class="bg-[#050505] min-h-screen text-white" x-data="{ 
    cantidad: 1, 
    stockMax: {{ $producto->stock }},
    precio: {{ $producto->precio }},
    nombre: '{{ $producto->nombre }}',
    isAgotado: {{ $producto->stock <= 0 ? 'true' : 'false' }}
}">
    {{-- Espaciador para Nav --}}
    <div class="h-24"></div>

    <div class="max-w-7xl mx-auto px-6 py-12">
        {{-- Breadcrumbs Estilo Minimal --}}
        <nav class="flex mb-12 text-[10px] font-black uppercase tracking-[0.4em] text-gray-500">
            <a href="{{ route('tienda.index') }}" class="hover:text-orange-500 transition-colors">Tienda</a>
            <span class="mx-3 text-orange-600">/</span>
            <span class="text-white">Detalle del Producto</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20">
            
            {{-- SECCIÓN VISUAL (Izquierda) --}}
            <div class="lg:col-span-7 space-y-6">
                <div class="relative group overflow-hidden rounded-[3rem] bg-[#0a0a0a] border border-white/5 shadow-2xl">
                    {{-- Badge de Categoría Flotante --}}
                    <div class="absolute top-8 left-8 z-20">
                        <span class="backdrop-blur-md bg-orange-600/20 text-orange-500 border border-orange-500/30 px-4 py-2 rounded-2xl text-[10px] font-black uppercase tracking-widest">
                            {{ $producto->categoria->nombre ?? 'Colección Pro' }}
                        </span>
                    </div>

                    {{-- Imagen con Zoom --}}
                    <div class="aspect-[4/5] flex items-center justify-center p-4 overflow-hidden">
                        <img src="{{ asset('storage/' . $producto->imagen) }}" 
                             alt="{{ $producto->nombre }}" 
                             class="w-full h-full object-contain transition-transform duration-[2s] group-hover:scale-110 {{ $producto->stock <= 0 ? 'grayscale opacity-50' : '' }}">
                    </div>

                    {{-- Overlay Sold Out --}}
                    @if($producto->stock <= 0)
                        <div class="absolute inset-0 flex items-center justify-center bg-black/40 backdrop-blur-[2px]">
                            <span class="border-4 border-orange-600 text-orange-600 px-8 py-3 font-black uppercase text-2xl -rotate-12 tracking-[0.2em] shadow-2xl">
                                AGOTADO
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- SECCIÓN INFORMACIÓN (Derecha) --}}
            <div class="lg:col-span-5 flex flex-col">
                <div class="mb-8">
                    <h1 class="text-5xl md:text-7xl font-black uppercase tracking-tighter leading-[0.85] mb-6">
                        {{ $producto->nombre }}
                    </h1>
                    
                    <div class="flex items-center gap-6 mb-8">
                        <span class="text-4xl font-black text-orange-500">
                            S/ {{ number_format($producto->precio, 2) }}
                        </span>
                        <span class="text-gray-600 font-bold line-through text-xl italic">
                            S/ {{ number_format($producto->precio * 1.25, 2) }}
                        </span>
                    </div>

                    <div class="p-6 rounded-[2rem] bg-white/[0.02] border border-white/5 backdrop-blur-sm italic">
                        <p class="text-gray-400 text-lg leading-relaxed font-medium">
                            "{{ $producto->descripcion }}"
                        </p>
                    </div>
                </div>

                {{-- CONFIGURADOR --}}
                <div class="space-y-10 mb-12">
                    {{-- Tallas --}}
                    <div>
                        <span class="text-[11px] font-black uppercase tracking-[0.3em] text-gray-500 block mb-5">Especificaciones</span>
                        <div class="flex flex-wrap gap-4">
                            <div class="px-6 py-4 rounded-2xl border-2 border-orange-600 bg-orange-600/10 text-orange-500 text-sm font-black flex items-center gap-3">
                                <i class="fa-solid fa-tags"></i>
                                {{ $producto->talla ?? 'TALLA ÚNICA' }}
                            </div>
                            <div class="px-6 py-4 rounded-2xl border-2 border-white/10 bg-white/5 text-white text-sm font-black flex items-center gap-3">
                                <i class="fa-solid fa-palette"></i>
                                {{ $producto->color ?? 'NEGRO PRO' }}
                            </div>
                        </div>
                    </div>

                    {{-- Cantidad y Stock --}}
                    <div class="flex flex-wrap items-center justify-between gap-6 py-8 border-y border-white/5">
                        <div class="flex items-center gap-4 bg-white/5 border border-white/10 rounded-2xl p-1.5">
                            <button @click="if(cantidad > 1) cantidad--" 
                                    class="w-12 h-12 flex items-center justify-center hover:bg-white/10 rounded-xl transition-all disabled:opacity-20"
                                    :disabled="cantidad <= 1 || isAgotado">
                                <i class="fa-solid fa-minus"></i>
                            </button>
                            <span class="font-black text-xl w-10 text-center" x-text="cantidad"></span>
                            <button @click="if(cantidad < stockMax) cantidad++" 
                                    class="w-12 h-12 flex items-center justify-center hover:bg-white/10 rounded-xl transition-all disabled:opacity-20"
                                    :disabled="cantidad >= stockMax || isAgotado">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>

                        <div class="text-right">
                            <span class="block text-[10px] font-black uppercase tracking-widest mb-1" 
                                  :class="isAgotado ? 'text-red-500' : 'text-green-500'">
                                {{ $producto->stock <= 5 && $producto->stock > 0 ? '¡Últimas unidades!' : ($producto->stock > 0 ? 'Stock Disponible' : 'Sin Stock') }}
                            </span>
                            <span class="text-2xl font-black">{{ $producto->stock }} <span class="text-xs text-gray-500">unids</span></span>
                        </div>
                    </div>
                </div>

                {{-- ACCIONES --}}
                <div class="flex flex-col gap-4">
                    <form action="{{ route('carrito.agregar', $producto->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="cantidad" :value="cantidad">
                        <button type="submit" 
                                :disabled="isAgotado"
                                class="w-full group relative overflow-hidden {{ $producto->stock > 0 ? 'bg-orange-600 hover:bg-orange-500 shadow-[0_15px_30px_rgba(234,88,12,0.3)]' : 'bg-gray-800 cursor-not-allowed opacity-50' }} text-white py-6 rounded-[2rem] font-black uppercase tracking-[0.2em] text-xs transition-all transform active:scale-95">
                            <span class="flex items-center justify-center gap-3">
                                <i class="fa-solid fa-cart-shopping {{ $producto->stock > 0 ? 'animate-bounce' : '' }}"></i>
                                {{ $producto->stock > 0 ? 'Añadir a mi Equipo' : 'Producto Agotado' }}
                            </span>
                        </button>
                    </form>

                    <a :href="'https://api.whatsapp.com/send?phone=51947637782&text=' + encodeURIComponent('¡Hola Academia Box! Me interesa el producto ' + nombre + ' en ' + cantidad + ' unidad(es).')" 
                       target="_blank" 
                       class="group bg-transparent text-white/60 py-5 rounded-[2rem] font-black uppercase tracking-[0.2em] text-[10px] border border-white/10 hover:border-green-500 hover:text-green-500 transition-all flex items-center justify-center gap-3">
                        <i class="fa-brands fa-whatsapp text-lg"></i>
                        Consultar Disponibilidad
                    </a>
                </div>

                {{-- Beneficios Minimal --}}
                <div class="mt-12 grid grid-cols-2 gap-6 border-t border-white/5 pt-8">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-white/5 flex items-center justify-center text-orange-500 border border-white/5">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <span class="text-[9px] font-black uppercase tracking-widest leading-tight">Garantía<br>Oficial</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-white/5 flex items-center justify-center text-orange-500 border border-white/5">
                            <i class="fa-solid fa-truck-fast"></i>
                        </div>
                        <span class="text-[9px] font-black uppercase tracking-widest leading-tight">Recojo<br>en Sede</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Efecto de suavizado para el zoom de imagen */
    img {
        backface-visibility: hidden;
        -webkit-font-smoothing: subpixel-antialiased;
    }
</style>
@endsection