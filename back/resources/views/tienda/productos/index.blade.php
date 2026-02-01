@extends('layouts.public')

@section('title', 'Tienda Oficial - Academia Box')

@section('content')
<div x-data="{ 
    genero: 'todos', 
    search: '',
    filter(nombre, gen) {
        const matchSearch = nombre.toLowerCase().includes(this.search.toLowerCase());
        const matchGen = this.genero === 'todos' || gen.toLowerCase() === this.genero;
        return matchSearch && matchGen;
    }
}">
    
    {{-- 1. HERO BANNER DINÁMICO CON ZOOM (KEN BURNS) Y CHISPAS --}}
    <section x-data="{ 
            activeSlide: 0, 
            slides: [
                'https://images.unsplash.com/photo-1595078475328-1ab05d0a6a0e?q=80&w=2000',
                'https://images.unsplash.com/photo-1549719386-74dfcbf7dbed?q=80&w=2000',
                'https://images.unsplash.com/photo-1517438322307-e67111335449?q=80&w=2000'
            ],
            init() {
                setInterval(() => {
                    this.activeSlide = (this.activeSlide + 1) % this.slides.length;
                }, 6000);
            }
        }" 
        class="relative h-[70vh] bg-[#050505] flex items-center overflow-hidden">
        
        {{-- SLIDESHOW CON ZOOM --}}
        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="activeSlide === index"
                 x-transition:enter="transition opacity duration-1000"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition opacity duration-1000"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="absolute inset-0">
                
                <img :src="slide" 
                     class="w-full h-full object-cover opacity-40 animate-ken-burns"
                     alt="Boxing Gear Slide">
            </div>
        </template>

        {{-- OVERLAY --}}
        <div class="absolute inset-0 bg-gradient-to-t from-[#050505] via-transparent to-black/60"></div>

        {{-- PARTICULAS TIPO CHISPAS (Solo en el Hero) --}}
        <div id="particles-hero" class="absolute inset-0 z-10 pointer-events-none"></div>

        {{-- CONTENIDO DEL HERO --}}
        <div class="relative z-20 max-w-7xl mx-auto px-6 w-full">
            <div class="flex flex-col items-start">
                <div class="inline-flex items-center gap-3 mb-4">
                    <span class="w-8 h-[2px] bg-orange-600"></span>
                    <span class="text-orange-600 font-black uppercase tracking-[0.4em] text-[10px]">Colección Pro 2026</span>
                </div>
                
                <h1 class="text-6xl md:text-8xl font-black text-white uppercase tracking-tighter leading-[0.85] mb-6">
                    EQUIPO DE<br>
                    <span class="text-orange-600 drop-shadow-[0_0_20px_rgba(234,88,12,0.5)]" 
                          x-text="activeSlide === 0 ? 'CAMPEONES' : (activeSlide === 1 ? 'GUERREROS' : 'LEYENDAS')">
                        CAMPEONES
                    </span>
                </h1>
                
                <p class="text-gray-400 max-w-md font-medium text-sm leading-relaxed border-l-2 border-orange-600 pl-6">
                    La armadura oficial de la Escuela El Tigre. Diseñada para resistir el contacto extremo y potenciar tu pegada.
                </p>

                {{-- INDICADORES --}}
                <div class="flex gap-3 mt-10">
                    <template x-for="(slide, index) in slides" :key="index">
                        <button @click="activeSlide = index" 
                                :class="activeSlide === index ? 'w-12 bg-orange-600' : 'w-3 bg-white/20 hover:bg-white/40'"
                                class="h-1.5 rounded-full transition-all duration-500"></button>
                    </template>
                </div>
            </div>
        </div>
    </section>

    {{-- 2. BARRA DE CONTROL (Sticky) --}}
    <section class="sticky top-[72px] z-30 bg-white/90 backdrop-blur-xl border-b border-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-4 flex flex-col md:flex-row justify-between items-center gap-6">
            
            {{-- Filtros --}}
            <div class="flex bg-gray-100/50 p-1.5 rounded-2xl w-full md:w-auto border border-gray-200">
                @foreach(['todos' => 'Todos', 'varon' => 'Varón', 'mujer' => 'Mujer'] as $key => $label)
                    <button @click="genero = '{{ $key }}'" 
                        :class="genero === '{{ $key }}' ? 'bg-black text-white shadow-lg' : 'text-gray-500 hover:text-black'"
                        class="flex-1 md:flex-none px-8 py-2.5 rounded-xl text-[10px] font-black uppercase transition-all duration-300">
                        {{ $label }}
                    </button>
                @endforeach
            </div>

            {{-- Buscador --}}
            <div class="relative w-full md:w-96 group">
                <input type="text" x-model="search" placeholder="Buscar equipo..." 
                       class="w-full pl-12 pr-4 py-3.5 bg-gray-100 border-transparent rounded-2xl focus:bg-white focus:ring-4 focus:ring-orange-600/10 focus:border-orange-500 transition-all text-xs font-bold tracking-widest uppercase">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-orange-600 transition-colors"></i>
            </div>
        </div>
    </section>

    {{-- 3. GRID DE PRODUCTOS --}}
    <section class="max-w-7xl mx-auto px-6 py-16">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-8 gap-y-14">
            
            @forelse($productos as $producto)
                @php $sinStock = $producto->stock <= 0; @endphp
                
                <div class="group" 
                     x-show="filter('{{ $producto->nombre }}', '{{ $producto->genero ?? 'unisex' }}')"
                     x-transition:enter="transition ease-out duration-400">
                    
                    {{-- Contenedor Imagen --}}
                    <div class="relative overflow-hidden bg-[#f3f3f3] rounded-[2rem] aspect-[3/4] shadow-sm group-hover:shadow-2xl transition-all duration-500">
                        
                        {{-- Imagen con Zoom y Grayscale si no hay stock --}}
                        <img src="{{ $producto->imagen_url }}" 
                             alt="{{ $producto->nombre }}" 
                             class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110 {{ $sinStock ? 'grayscale opacity-60' : '' }}">
                        
                        {{-- Badge Sold Out --}}
                        @if($sinStock)
                            <div class="absolute inset-0 flex items-center justify-center z-30">
                                <span class="bg-black text-white px-6 py-2 -rotate-12 font-black uppercase tracking-[0.3em] text-[10px] border-2 border-orange-600 shadow-2xl">
                                    Sold Out
                                </span>
                            </div>
                        @endif

                        {{-- Precio --}}
                        <div class="absolute top-4 right-4 bg-black text-white px-4 py-2 rounded-full font-black text-sm shadow-xl z-20">
                            S/ {{ number_format($producto->precio, 2) }}
                        </div>

                        {{-- Overlay Detalle --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-orange-600/90 via-orange-600/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center p-8">
                            <a href="{{ route('tienda.show', $producto->id) }}" 
                               class="w-full bg-white text-black py-4 rounded-2xl font-black uppercase text-[10px] tracking-[0.2em] text-center hover:bg-black hover:text-white transition-all shadow-2xl transform translate-y-4 group-hover:translate-y-0 duration-500">
                                {{ $sinStock ? 'Ver Información' : 'Ver Detalles' }}
                            </a>
                        </div>
                    </div>

                    {{-- Info del Producto --}}
                    <div class="mt-6 px-2">
                        <span class="text-[9px] font-black text-orange-600 uppercase tracking-[0.3em]">{{ $producto->genero }}</span>
                        <h3 class="text-md font-black uppercase tracking-tight text-gray-900 mt-1 leading-tight {{ $sinStock ? 'text-gray-400 line-through' : 'group-hover:text-orange-600 transition-colors' }}">
                            {{ $producto->nombre }}
                        </h3>
                        
                        <div class="mt-4 flex justify-between items-center">
                             <div class="flex flex-col">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $producto->talla }}</span>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="w-2 h-2 rounded-full {{ $sinStock ? 'bg-red-500' : 'bg-green-500' }}"></span>
                                    <span class="text-[9px] font-bold uppercase {{ $sinStock ? 'text-red-600' : 'text-green-600' }}">
                                        {{ $sinStock ? 'Agotado' : 'Disponible' }}
                                    </span>
                                </div>
                             </div>
                             
                             <button {{ $sinStock ? 'disabled' : '' }} 
                                class="w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center transition-all {{ $sinStock ? 'opacity-20 cursor-not-allowed' : 'hover:bg-orange-600 hover:border-orange-600 hover:text-white hover:rotate-12' }}">
                                <i class="fa-solid fa-cart-plus text-xs"></i>
                             </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center">
                    <i class="fa-solid fa-box-open text-6xl text-gray-200 mb-4 block"></i>
                    <h2 class="text-2xl font-black uppercase tracking-tighter">Sin resultados</h2>
                </div>
            @endforelse

        </div>
    </section>
</div>

{{-- SCRIPTS --}}
<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
<script>
    particlesJS("particles-hero", {
        particles: {
            number: { value: 70, density: { enable: true, value_area: 800 } },
            color: { value: "#f97316" },
            shape: { type: "circle" },
            opacity: { value: 0.6, random: true },
            size: { value: 2.5, random: true },
            line_linked: { enable: false },
            move: { enable: true, speed: 4, direction: "top", random: true, out_mode: "out" }
        }
    });
</script>

<style>
    @keyframes ken-burns {
        0% { transform: scale(1); }
        100% { transform: scale(1.15); }
    }
    .animate-ken-burns {
        animation: ken-burns 8s ease-out forwards;
    }
    [x-cloak] { display: none !important; }
</style>
@endsection