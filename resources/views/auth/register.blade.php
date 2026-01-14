@extends('layouts.guest')

@section('title', 'Registro de Atletas')

@section('content')
<div class="relative min-h-screen flex items-center justify-center overflow-hidden bg-[#050505]">

    {{-- FONDO CON PARALLAX --}}
    <div class="absolute inset-0 bg-cover bg-center scale-110 motion-safe:animate-[pulse_10s_ease-in-out_infinite]"
        style="background-image: url('{{ asset('images/portada.png') }}'); filter: grayscale(50%) contrast(110%);">
    </div>

    {{-- OVERLAY --}}
    <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/90 to-black"></div>

    {{-- PARTICULAS TIPO CHISPAS (Z-INDEX 1) --}}
    <div id="particles-js" class="absolute inset-0 z-[1] pointer-events-none"></div>

    {{-- REGISTER CARD (ULTRA-COMPACTA) --}}
    <div class="relative z-10 w-full max-w-sm mx-4 my-4">
        <div class="absolute inset-0 bg-white/[0.02] backdrop-blur-xl rounded-[2.5rem] border border-white/10 shadow-2xl"></div>
        
        <div class="relative p-6 sm:p-8 flex flex-col items-center">
            
            {{-- LOGO BOX (PEQUEÑO PARA AHORRAR ESPACIO) --}}
            <div class="relative mb-4">
                <div class="logo-register w-16 h-16 rounded-2xl border-2 border-orange-500 bg-black/80 p-2 shadow-[0_0_15px_rgba(249,115,22,0.4)] flex items-center justify-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-full h-full object-contain">
                </div>
            </div>

            <div class="text-center mb-5">
                <h1 class="text-xl font-black text-white tracking-tighter uppercase leading-none">
                    NUEVA <span class="text-orange-500">CUENTA</span>
                </h1>
                <p class="text-[8px] font-bold text-gray-500 uppercase tracking-[0.3em] mt-1">Únete a la Escuela El Tigre</p>
            </div>

            {{-- ERRORES --}}
            @if ($errors->any())
                <div class="w-full mb-4 bg-red-500/10 border border-red-500/20 text-red-400 px-3 py-2 rounded-xl text-[10px] font-bold uppercase tracking-widest animate-shake text-center">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- FORMULARIO --}}
            <form method="POST" action="{{ route('register') }}" class="w-full space-y-3">
                @csrf

                {{-- NOMBRE --}}
                <div class="relative group">
                    <i class="fa-solid fa-signature absolute left-4 top-1/2 -translate-y-1/2 text-gray-600 text-xs group-focus-within:text-orange-500 transition-colors"></i>
                    <input type="text" name="name" placeholder="Nombre Completo" value="{{ old('name') }}" required autofocus
                        class="w-full bg-black/40 border border-white/10 focus:border-orange-500 focus:ring-0 rounded-xl pl-10 pr-4 py-2.5 text-sm text-white placeholder-gray-600 transition-all">
                </div>

                {{-- EMAIL --}}
                <div class="relative group">
                    <i class="fa-solid fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-600 text-xs group-focus-within:text-orange-500 transition-colors"></i>
                    <input type="email" name="email" placeholder="Correo Electrónico" value="{{ old('email') }}" required
                        class="w-full bg-black/40 border border-white/10 focus:border-orange-500 focus:ring-0 rounded-xl pl-10 pr-4 py-2.5 text-sm text-white placeholder-gray-600 transition-all">
                </div>

                {{-- PASSWORD --}}
                <div class="relative group">
                    <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-600 text-xs group-focus-within:text-orange-500 transition-colors"></i>
                    <input type="password" name="password" placeholder="Contraseña" required
                        class="w-full bg-black/40 border border-white/10 focus:border-orange-500 focus:ring-0 rounded-xl pl-10 pr-4 py-2.5 text-sm text-white transition-all">
                </div>

                {{-- CONFIRM PASSWORD --}}
                <div class="relative group">
                    <i class="fa-solid fa-shield-check absolute left-4 top-1/2 -translate-y-1/2 text-gray-600 text-xs group-focus-within:text-orange-500 transition-colors"></i>
                    <input type="password" name="password_confirmation" placeholder="Confirmar Contraseña" required
                        class="w-full bg-black/40 border border-white/10 focus:border-orange-500 focus:ring-0 rounded-xl pl-10 pr-4 py-2.5 text-sm text-white transition-all">
                </div>

                <div class="space-y-3 pt-4">
                    <button type="submit"
                        class="w-full bg-orange-600 hover:bg-orange-500 text-white py-3 rounded-xl font-black uppercase tracking-widest text-xs transition-all shadow-lg shadow-orange-900/40 transform active:scale-95">
                        REGISTRARSE
                    </button>
                    
                    <a href="{{ route('login') }}"
                        class="block w-full text-center py-2 rounded-xl text-white/40 hover:text-white font-bold uppercase tracking-widest text-[9px] transition-all">
                        ¿Ya tienes cuenta? Inicia Sesión
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- PARTICULAS TIPO CHISPAS --}}
<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
<script>
particlesJS("particles-js", {
    particles: {
        number: { value: 90, density: { enable: true, value_area: 800 } },
        color: { value: "#f97316" },
        shape: { type: "circle" },
        opacity: { value: 0.6, random: true },
        size: { value: 2.5, random: true },
        line_linked: { enable: false },
        move: { enable: true, speed: 3, direction: "top", random: true, out_mode: "out" }
    }
});
</script>

<style>
.logo-register {
    animation: floating 4s ease-in-out infinite, glowPulse 5s ease-in-out infinite;
}
@keyframes floating {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-5px); }
}
@keyframes glowPulse {
    0%, 100% { box-shadow: 0 0 10px rgba(249,115,22,0.3); }
    50% { box-shadow: 0 0 25px rgba(249,115,22,0.6); }
}
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}
.animate-shake { animation: shake 0.3s ease-in-out 3; }
</style>
@endsection