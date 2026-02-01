{{-- resources/views/alumnos/partials/tab-finanzas.blade.php --}}

<div x-data="{ 
    openPagoModal: false, 
    montoPago: '{{ number_format($totalPendiente ?? 0, 2, '.', '') }}', 
    inscripcionId: '' 
}" class="animate-fadeIn">

    @php
        $cuentasInscripcion = $alumno->cuentasInscripcion ?? collect();
        $todasLasCuotas = $cuentasInscripcion->flatMap(fn ($c) => $c->cuotas);

        $totalAsignado = $todasLasCuotas->sum('monto');
        $totalPagado = $todasLasCuotas->sum(fn ($c) => $c->monto_pagado_total ?? 0);
        $totalPendiente = $todasLasCuotas->sum(fn ($c) => $c->monto_pendiente ?? 0);

        // Moneda local
        $moneda = 'S/';
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-3 space-y-10">
            
            {{-- 1. RESUMEN FINANCIERO (Tarjetas con brillo) --}}
            <div class="relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-orange-600 to-red-600 rounded-2xl blur opacity-10 group-hover:opacity-20 transition duration-1000"></div>
                <div class="relative">
                    @include('alumnos.partials.finanzas.resumen', [
                        'totalAsignado' => $totalAsignado,
                        'totalPagado' => $totalPagado,
                        'totalPendiente' => $totalPendiente,
                        'moneda' => $moneda,
                    ])
                </div>
            </div>
            
            {{-- 2. SECCIÓN DE CUOTAS PENDIENTES --}}
            <div class="bg-[#1a1a1a] rounded-3xl p-6 border border-white/5 shadow-2xl">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2 bg-orange-600/10 rounded-lg">
                        <i class="fa-solid fa-clock-rotate-left text-orange-500"></i>
                    </div>
                    <h3 class="text-sm font-black uppercase tracking-[0.2em] text-white">Pendientes de Cobro</h3>
                </div>

                @include('alumnos.partials.finanzas.cuotas-pendientes', [
                    'todasLasCuotas' => $todasLasCuotas,
                    'alumno' => $alumno,
                    'moneda' => $moneda
                ])
            </div>
            
            {{-- 3. HISTORIAL DE TRANSACCIONES --}}
            <div class="bg-[#141414] rounded-3xl p-6 border border-white/5 shadow-inner">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2 bg-gray-500/10 rounded-lg">
                        <i class="fa-solid fa-receipt text-gray-400"></i>
                    </div>
                    <h3 class="text-sm font-black uppercase tracking-[0.2em] text-gray-400">Historial Completo</h3>
                </div>

                @include('alumnos.partials.finanzas.historial-cuotas', [
                    'todasLasCuotas' => $todasLasCuotas,
                    'moneda' => $moneda
                ])
            </div>
        </div>

    </div>

    {{-- MODAL DE PAGO (Diseño Oscuro) --}}
    <div x-show="openPagoModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-cloak
         class="fixed inset-0 z-[999] flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm">
        
        <div class="bg-[#1a1a1a] border border-white/10 w-full max-w-md rounded-3xl shadow-2xl overflow-hidden" @click.away="openPagoModal = false">
            <div class="p-8">
                @include('alumnos.partials.finanzas.modal-pago', [
                    'alumno' => $alumno,
                    'tiposPago' => $tiposPago ?? collect(),
                    'moneda' => $moneda
                ])
            </div>
        </div>
    </div>

</div>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeIn {
        animation: fadeIn 0.4s ease-out forwards;
    }
</style>