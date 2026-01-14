@php
    $moneda = 'S/';
@endphp

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ---------------------------------------------------- --}}
    {{-- COLUMNA LATERAL (1/3): DATOS PRINCIPALES Y ACCIONES --}}
    {{-- ---------------------------------------------------- --}}
    <div class="lg:col-span-1 space-y-6">
        <div class="sticky lg:top-6">
            {{-- Importante: El archivo 'datos-card' también debería ser oscurecido --}}
            @include('alumnos.partials.datos-card', [
                'alumno' => $alumno,
                'moneda' => $moneda
            ])
        </div>
    </div>

    {{-- ---------------------------------------------------- --}}
    {{-- COLUMNA PRINCIPAL (2/3): INSCRIPCIONES Y OTROS --}}
    {{-- ---------------------------------------------------- --}}
    <div class="lg:col-span-2 space-y-6">
        
        {{-- 💡 0. RELOJ ESTILO GIMNASIO (Dark Mode) --}}
        <div class="bg-gradient-to-r from-[#1a1a1a] to-orange-900/20 text-white p-6 rounded-2xl shadow-2xl border border-white/5 flex items-center justify-between">
            
            {{-- Contenedor del Reloj Analógico --}}
            <div class="w-1/3 flex justify-center">
                <div id="clock" class="clock-face">
                    <div id="hour" class="hand hour-hand"></div>
                    <div id="minute" class="hand minute-hand"></div>
                    <div id="second" class="hand second-hand"></div>
                    <div class="center-dot"></div>
                </div>
            </div>

            {{-- Información de Fecha y Hora --}}
            <div class="w-2/3 pl-8 border-l border-white/10">
                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-orange-500 block mb-1">
                    System Time ({{ config('app.timezone') }})
                </span>
                <div id="reloj-digital" class="text-4xl font-black italic tracking-tighter mb-2 text-white drop-shadow-md">
                    {{ now()->setTimezone(config('app.timezone'))->format('H:i:s A') }} 
                </div>
                
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-calendar-day text-orange-500 text-xs"></i>
                    <span class="text-sm font-bold text-gray-300 uppercase tracking-widest">{{ now()->translatedFormat('l, d F Y') }}</span>
                </div>
            </div>
        </div>

        {{-- 1. INSCRIPCIONES Y PROGRAMAS (Contenedor Oscuro) --}}
        <div class="bg-[#1a1a1a] shadow-xl rounded-2xl p-6 border border-white/5">
            <h2 class="text-xs font-black text-orange-500 uppercase tracking-[0.3em] mb-6 flex items-center gap-3">
                <i class="fa-solid fa-file-signature text-lg"></i> Programas Activos
            </h2>
            @include('alumnos.partials.inscripciones-programas', [
                'alumno' => $alumno,
                'moneda' => $moneda
            ])
        </div>

        {{-- 2. DOCUMENTOS Y NOTAS --}}
        <div class="bg-[#1a1a1a] shadow-xl rounded-2xl p-6 border border-white/5">
            <h2 class="text-xs font-black text-gray-400 uppercase tracking-[0.3em] border-b border-white/10 pb-4 flex items-center gap-3">
                <i class="fa-solid fa-folder-open text-lg"></i> Documentos y Notas
            </h2>
            <div class="py-10 flex flex-col items-center justify-center text-center">
                <i class="fa-solid fa-box-archive text-4xl text-white/5 mb-4"></i>
                <p class="text-gray-500 italic text-sm max-w-xs">
                    No hay documentos adicionales adjuntos en el historial académico.
                </p>
            </div>
        </div>
        
    </div>
</div>

{{-- Estilos actualizados para el reloj en modo oscuro --}}
@push('styles')
<style>
    .clock-face {
        position: relative;
        width: 110px;
        height: 110px;
        border-radius: 50%;
        border: 4px solid #333; /* Borde oscuro */
        background-color: #000;
        box-shadow: 0 0 20px rgba(234, 88, 12, 0.2); /* Brillo naranja */
    }
    .center-dot {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 8px;
        height: 8px;
        background: #ea580c; /* Punto naranja */
        border-radius: 50%;
        transform: translate(-50%, -50%);
        z-index: 10;
    }
    .hand {
        position: absolute;
        top: 50%;
        left: 50%;
        transform-origin: 0% 0%;
        border-radius: 4px;
        margin-top: -2px;
    }
    .hour-hand { width: 30px; height: 5px; background: #fff; z-index: 3; }
    .minute-hand { width: 42px; height: 3px; background: #999; z-index: 2; }
    .second-hand { width: 48px; height: 1.5px; background: #ea580c; z-index: 1; }
</style>
@endpush