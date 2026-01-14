@extends('layouts.guest')

@section('title', 'Inicio | Escuela de Box El Tigre')

@section('content')
<div class="relative overflow-hidden bg-black">

    {{-- 1. FONDO (Capa más profunda) --}}
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-cover bg-center animate-slow-zoom scale-100"
            style="background-image: url('{{ asset('images/portada.png') }}'); background-attachment: fixed;">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/90 via-black/20 to-black/95"></div>
    </div>

    {{-- 2. PARTICULAS (Capa intermedia - AHORA MÁS VISIBLES) --}}
    <div id="particles-js" class="absolute inset-0 z-10"></div>

    {{-- 3. CONTENIDO (Capa superior) --}}
    <section class="relative z-20 min-h-screen flex items-center pt-20">
        <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-12 items-center">
            
            {{-- Columna Texto --}}
            <div class="text-left space-y-8">
                <div class="inline-flex items-center gap-2 bg-orange-600/20 border border-orange-600/30 px-4 py-1.5 rounded-full">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-orange-500"></span>
                    </span>
                    <span class="text-orange-500 text-[10px] font-black uppercase tracking-widest">Sistema Profesional V2.0</span>
                </div>

                <h1 class="text-5xl md:text-7xl font-black text-white leading-[0.9] tracking-tighter uppercase italic">
                    Unete a Nuestra<br>
                    <span class="text-orange-600 drop-shadow-[0_0_20px_rgba(234,88,12,0.6)]">Escuela de Box</span><br>
                    <span class="text-3xl md:text-5xl font-light italic tracking-normal text-gray-400">Fuerza y Control.</span>
                </h1>

                <p class="text-gray-400 text-lg md:text-xl max-w-xl leading-relaxed font-medium">
                    Domina la administración de tu gimnasio. Control de alumnos, pagos y progreso deportivo en una plataforma diseñada para campeones.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <a href="{{ route('register') }}"
                        class="group bg-orange-600 hover:bg-orange-500 text-white px-10 py-4 rounded-xl font-black uppercase text-xs tracking-[0.2em] transition-all flex items-center justify-center gap-3 shadow-lg shadow-orange-600/20">
                        Crear cuenta
                        <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                    </a>

                    <a href="{{ route('login') }}"
                        class="bg-white/5 hover:bg-white/10 backdrop-blur-md border border-white/10 text-white px-10 py-4 rounded-xl font-black uppercase text-xs tracking-[0.2em] transition-all flex items-center justify-center">
                        Iniciar sesión
                    </a>
                </div>
            </div>

            {{-- Columna Logo --}}
            <div class="hidden lg:flex justify-center items-center">
                <div class="relative group">
                    <div class="absolute -inset-4 bg-orange-600 rounded-full opacity-10 blur-3xl group-hover:opacity-30 transition duration-1000"></div>
                    
                    <div class="relative w-80 h-80 rounded-full border-[12px] border-white/5 bg-black/40 backdrop-blur-xl p-8 flex items-center justify-center animate-float overflow-hidden">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-full h-full object-contain drop-shadow-[0_0_30px_rgba(255,255,255,0.2)]">
                        <div class="absolute top-0 -left-[100%] w-1/2 h-full bg-gradient-to-r from-transparent via-white/10 to-transparent skew-x-[-25deg] animate-shine"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- BENEFICIOS --}}
    <section class="relative z-20 py-32 bg-[#050505]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid md:grid-cols-3 gap-8">
                <div class="group bg-neutral-900/50 border border-white/5 p-10 rounded-[2.5rem] hover:bg-orange-600 transition-all duration-500">
                    <div class="w-14 h-14 bg-orange-600 group-hover:bg-white rounded-2xl flex items-center justify-center mb-8 rotate-3 transition-all shadow-xl shadow-orange-600/20">
                        <i class="fa-solid fa-users text-black text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-black mb-4 text-white group-hover:text-black uppercase">Gestión Deportiva</h3>
                    <p class="text-gray-500 group-hover:text-black/80 font-medium italic">Control de alumnos y asistencia con un solo toque.</p>
                </div>

                <div class="group bg-neutral-900/50 border border-white/5 p-10 rounded-[2.5rem] hover:bg-orange-600 transition-all duration-500">
                    <div class="w-14 h-14 bg-orange-600 group-hover:bg-white rounded-2xl flex items-center justify-center mb-8 transition-all shadow-xl shadow-orange-600/20">
                        <i class="fa-solid fa-money-bill-trend-up text-black text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-black mb-4 text-white group-hover:text-black uppercase">Control Financiero</h3>
                    <p class="text-gray-500 group-hover:text-black/80 font-medium italic">Pagos y reportes automáticos para tu tranquilidad.</p>
                </div>

                <div class="group bg-neutral-900/50 border border-white/5 p-10 rounded-[2.5rem] hover:bg-orange-600 transition-all duration-500">
                    <div class="w-14 h-14 bg-orange-600 group-hover:bg-white rounded-2xl flex items-center justify-center mb-8 -rotate-3 transition-all shadow-xl shadow-orange-600/20">
                        <i class="fa-solid fa-shield-halved text-black text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-black mb-4 text-white group-hover:text-black uppercase">Seguro y Pro</h3>
                    <p class="text-gray-500 group-hover:text-black/80 font-medium italic">Tecnología Laravel 12 aplicada al crecimiento deportivo.</p>
                </div>
            </div>
        </div>
    </section>
</div>

{{-- SCRIPTS --}}
<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
<script>
    particlesJS("particles-js", {
        "particles": {
            "number": { "value": 80, "density": { "enable": true, "value_area": 800 } },
            "color": { "value": "#f97316" }, // NARANJA FUERTE
            "shape": { "type": "circle" },
            "opacity": { 
                "value": 0.8, // SUBIMOS OPACIDAD
                "random": true, 
                "anim": { "enable": true, "speed": 1, "opacity_min": 0.1, "sync": false } 
            },
            "size": { "value": 3, "random": true },
            "line_linked": { 
                "enable": true, 
                "distance": 150, 
                "color": "#f97316", // LÍNEAS NARANJAS
                "opacity": 0.4, 
                "width": 1 
            },
            "move": { 
                "enable": true, 
                "speed": 2, 
                "direction": "none", 
                "random": false, 
                "straight": false, 
                "out_mode": "out", 
                "bounce": false 
            }
        },
        "interactivity": {
            "detect_on": "canvas",
            "events": {
                "onhover": { "enable": true, "mode": "grab" },
                "onclick": { "enable": true, "mode": "push" }
            },
            "modes": {
                "grab": { "distance": 200, "line_linked": { "opacity": 1 } }
            }
        },
        "retina_detect": true
    });
</script>

<style>
    /* ZOOM LEVE PARA IMAGEN 2000x874 */
    @keyframes slow-zoom {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    .animate-slow-zoom {
        animation: slow-zoom 25s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }
    .animate-float {
        animation: float 5s ease-in-out infinite;
    }

    @keyframes shine {
        0% { left: -100%; }
        20% { left: 100%; }
        100% { left: 100%; }
    }
    .animate-shine {
        animation: shine 6s infinite;
    }
</style>
@endsection