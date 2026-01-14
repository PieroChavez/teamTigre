@extends('layouts.guest')

@section('title', 'Acceso Combatientes')

@section('content')
<div class="relative min-h-screen flex items-center justify-center overflow-hidden bg-[#050505]">

    {{-- FONDO CON PARALLAX --}}
    <div class="absolute inset-0 bg-cover bg-center scale-110 motion-safe:animate-[pulse_10s_ease-in-out_infinite]"
        style="background-image: url('{{ asset('images/portada.png') }}'); filter: grayscale(50%) contrast(110%);">
    </div>

    {{-- OVERLAY --}}
    <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/90 to-black"></div>

    {{-- PARTICULAS (Z-INDEX 1) --}}
    <div id="particles-js" class="absolute inset-0 z-[1] pointer-events-none"></div>

    {{-- LOGIN CARD (COMPACTA) --}}
    <div class="relative z-10 w-full max-w-sm mx-4">
        <div class="absolute inset-0 bg-white/[0.02] backdrop-blur-xl rounded-[2.5rem] border border-white/10 shadow-2xl"></div>
        
        <div class="relative p-8 flex flex-col items-center">
            
            {{-- LOGO BOX (REDUCIDO) --}}
            <div class="relative mb-6">
                <div class="logo-box w-20 h-20 rounded-2xl border-2 border-orange-500 bg-black/80 p-2 shadow-[0_0_20px_rgba(249,115,22,0.4)] flex items-center justify-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-full h-full object-contain">
                </div>
            </div>

            <div class="text-center mb-6">
                <h1 class="text-2xl font-black text-white tracking-tighter uppercase leading-none">
                    EL TIGRE <span class="text-orange-500">BOX</span>
                </h1>
                <p class="text-[9px] font-bold text-gray-500 uppercase tracking-[0.3em] mt-1">Gimnasio & Escuela</p>
            </div>

            {{-- FORMULARIO (MÁS COMPACTO) --}}
            <form method="POST" action="{{ route('login') }}" class="w-full space-y-4">
                @csrf

                <div class="space-y-1">
                    <div class="relative group">
                        <i class="fa-solid fa-user absolute left-4 top-1/2 -translate-y-1/2 text-gray-600 text-xs group-focus-within:text-orange-500 transition-colors"></i>
                        <input type="email" name="email" placeholder="Correo Electrónico" required autofocus
                            class="w-full bg-black/40 border border-white/10 focus:border-orange-500 focus:ring-0 rounded-xl pl-10 pr-4 py-3 text-sm text-white placeholder-gray-600 transition-all font-medium">
                    </div>
                </div>

                <div class="space-y-1">
                    <div class="relative group">
                        <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-600 text-xs group-focus-within:text-orange-500 transition-colors"></i>
                        <input type="password" name="password" placeholder="Contraseña" required
                            class="w-full bg-black/40 border border-white/10 focus:border-orange-500 focus:ring-0 rounded-xl pl-10 pr-4 py-3 text-sm text-white transition-all font-medium">
                    </div>
                </div>

                <div class="flex items-center justify-between px-1">
                    <label class="flex items-center cursor-pointer group">
                        <input type="checkbox" name="remember" class="w-3.5 h-3.5 rounded border-white/10 bg-white/5 text-orange-500 focus:ring-0">
                        <span class="ml-2 text-[10px] font-bold text-gray-500 group-hover:text-gray-300 uppercase tracking-widest transition-colors">Recordarme</span>
                    </label>
                </div>

                <div class="space-y-3 pt-2">
                    <button type="submit"
                        class="w-full bg-orange-600 hover:bg-orange-500 text-white py-3 rounded-xl font-black uppercase tracking-widest text-xs transition-all shadow-lg shadow-orange-900/40 transform active:scale-95">
                        ENTRAR AL RING
                    </button>
                    
                    <a href="{{ route('register') }}"
                        class="block w-full text-center py-3 rounded-xl border border-white/5 text-white/40 hover:text-white hover:bg-white/5 font-bold uppercase tracking-widest text-[9px] transition-all">
                        SOLICITAR ACCESO
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- PARTICULAS INTENSIFICADAS --}}
<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
<script>
particlesJS("particles-js", {
    particles: {
        number: { value: 100, density: { enable: true, value_area: 800 } },
        color: { value: "#f97316" }, // Naranja vibrante
        shape: { type: "circle" },
        opacity: { value: 0.6, random: true }, // Más opacidad para que se vean
        size: { value: 2.5, random: true },
        line_linked: { enable: false }, // Quitamos líneas para un look más limpio de "chispas"
        move: { enable: true, speed: 2.5, direction: "top", random: true, out_mode: "out" } // Movimiento hacia arriba como chispas
    }
});
</script>

<style>
.logo-box {
    animation: floating 4s ease-in-out infinite;
}
@keyframes floating {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-5px); }
}
/* Estilizar el checkbox para que combine con el dark mode */
input[type="checkbox"] {
    appearance: none;
    background-color: rgba(255,255,255,0.05);
    margin: 0;
    font: inherit;
    color: #f97316;
    width: 1.15em;
    height: 1.15em;
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 0.15em;
    transform: translateY(-0.075em);
    display: grid;
    place-content: center;
}
</style>
@endsection