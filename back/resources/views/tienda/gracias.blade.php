@extends('layouts.public')

@section('title', '¡Pedido Recibido! | Academia Box')

@section('content')
<div class="bg-white min-h-screen flex flex-col items-center justify-center relative overflow-hidden">
    
    {{-- Decoración de fondo (Branding sutil) --}}
    <div class="absolute top-0 left-0 w-full h-full pointer-events-none opacity-[0.03] select-none flex items-center justify-center">
        <span class="text-[20vw] font-black uppercase tracking-tighter leading-none text-black">NO PAIN NO GAIN</span>
    </div>

    <div class="max-w-3xl mx-auto px-6 py-24 relative z-10 text-center">
        
        {{-- Indicador de Éxito --}}
        <div class="mb-12 relative inline-block">
            <div class="w-32 h-32 bg-black rounded-[2.5rem] rotate-12 flex items-center justify-center shadow-2xl transition-transform hover:rotate-0 duration-500">
                <i class="fa-solid fa-check text-5xl text-orange-600 -rotate-12 transition-transform"></i>
            </div>
            {{-- Partículas decorativas --}}
            <div class="absolute -top-4 -right-4 w-8 h-8 bg-orange-600 rounded-full animate-ping opacity-20"></div>
        </div>

        {{-- Encabezado Impactante --}}
        <div class="space-y-2 mb-10">
            <h1 class="text-6xl md:text-8xl font-black uppercase tracking-tighter text-black leading-none">
                ¡ORDEN <span class="text-orange-600">LISTA!</span>
            </h1>
            <p class="text-gray-400 font-black uppercase tracking-[0.4em] text-[10px]">Tu pedido ha sido registrado con éxito</p>
        </div>
        
        {{-- Tarjeta de Instrucciones --}}
        <div class="bg-gray-50 rounded-[3rem] p-10 md:p-14 mb-12 border border-gray-100 shadow-sm text-left">
            <h2 class="text-xl font-black uppercase tracking-tight text-black mb-6 flex items-center gap-3">
                <span class="w-2 h-8 bg-orange-600 inline-block"></span>
                ¿Qué sigue ahora?
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <span class="text-[10px] font-black uppercase text-orange-600 tracking-widest">Paso 01</span>
                    <p class="text-sm font-bold text-gray-800">Haz clic en el botón de abajo para enviarnos tu pedido por WhatsApp.</p>
                </div>
                <div class="space-y-2">
                    <span class="text-[10px] font-black uppercase text-orange-600 tracking-widest">Paso 02</span>
                    <p class="text-sm font-bold text-gray-800">Coordinaremos el método de pago y el horario de entrega en segundos.</p>
                </div>
            </div>
        </div>

        {{-- BOTÓN DE ACCIÓN (ESTILO NEUMÓRFICO/MODERNO) --}}
        <div class="flex flex-col items-center gap-6">
            <a href="{{ $urlWhatsapp }}" 
               class="group relative inline-flex items-center justify-center w-full md:w-auto md:min-w-[400px] bg-[#25D366] text-white py-8 px-12 rounded-3xl font-black uppercase tracking-[0.2em] text-xs transition-all hover:bg-black hover:shadow-[0_30px_60px_-15px_rgba(0,0,0,0.3)] hover:-translate-y-1">
                <span class="flex items-center gap-4">
                    <i class="fa-brands fa-whatsapp text-2xl group-hover:scale-110 transition-transform"></i>
                    Finalizar por WhatsApp
                </span>
            </a>

            <button onclick="window.location.href='{{ route('tienda.index') }}'" class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 hover:text-black transition-colors cursor-pointer">
                O volver a explorar la tienda
            </button>
        </div>

    </div>
</div>

<style>
    /* Efecto de entrada suave */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .relative.z-10 {
        animation: fadeInUp 0.8s ease-out forwards;
    }
</style>
@endsection