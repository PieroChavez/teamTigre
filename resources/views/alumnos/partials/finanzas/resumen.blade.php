{{-- Resumen Financiero - Estilo Atleta de Élite --}}

<div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
    
    {{-- TARJETA: TOTAL ASIGNADO --}}
    <div class="relative overflow-hidden bg-[#1a1a1a] rounded-2xl p-5 border border-white/5 shadow-2xl group transition-all duration-300 hover:border-orange-500/30">
        {{-- Icono de fondo decorativo --}}
        <div class="absolute -right-4 -bottom-4 text-white/5 text-6xl group-hover:text-orange-500/10 transition-colors">
            <i class="fa-solid fa-file-invoice"></i>
        </div>
        
        <div class="relative z-10">
            <p class="text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-2 flex items-center gap-2">
                <span class="w-2 h-2 bg-gray-600 rounded-full"></span>
                Inversión Total
            </p>
            <div class="flex items-baseline gap-1">
                <span class="text-lg font-black text-orange-500">S/</span>
                <p class="text-4xl font-black text-white tracking-tighter tabular-nums">
                    {{ number_format($totalAsignado, 2) }}
                </p>
            </div>
            <div class="mt-4 h-1 w-full bg-white/5 rounded-full overflow-hidden">
                <div class="h-full bg-gray-600 w-full opacity-50"></div>
            </div>
        </div>
    </div>

    {{-- TARJETA: TOTAL PAGADO --}}
    <div class="relative overflow-hidden bg-[#1a1a1a] rounded-2xl p-5 border border-white/5 shadow-2xl group transition-all duration-300 hover:border-green-500/30">
        {{-- Icono de fondo decorativo --}}
        <div class="absolute -right-4 -bottom-4 text-white/5 text-6xl group-hover:text-green-500/10 transition-colors">
            <i class="fa-solid fa-money-bill-trend-up"></i>
        </div>

        <div class="relative z-10">
            <p class="text-[10px] font-black text-green-500 uppercase tracking-[0.2em] mb-2 flex items-center gap-2">
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                Monto Recaudado
            </p>
            <div class="flex items-baseline gap-1">
                <span class="text-lg font-black text-green-500">S/</span>
                <p class="text-4xl font-black text-white tracking-tighter tabular-nums">
                    {{ number_format($totalPagado, 2) }}
                </p>
            </div>
            {{-- Barra de progreso visual --}}
            @php 
                $porcentaje = $totalAsignado > 0 ? ($totalPagado / $totalAsignado) * 100 : 0;
            @endphp
            <div class="mt-4 h-1.5 w-full bg-white/5 rounded-full overflow-hidden">
                <div class="h-full bg-green-500 shadow-[0_0_10px_rgba(34,197,94,0.8)] transition-all duration-1000" 
                     style="width: {{ $porcentaje }}%"></div>
            </div>
        </div>
    </div>

    {{-- TARJETA: DEUDA PENDIENTE --}}
    <div class="relative overflow-hidden bg-[#1a1a1a] rounded-2xl p-5 border border-white/5 shadow-2xl group transition-all duration-300 hover:border-red-500/30">
        {{-- Icono de fondo decorativo --}}
        <div class="absolute -right-4 -bottom-4 text-white/5 text-6xl group-hover:text-red-500/10 transition-colors">
            <i class="fa-solid fa-hand-holding-dollar"></i>
        </div>

        <div class="relative z-10">
            <p class="text-[10px] font-black text-red-500 uppercase tracking-[0.2em] mb-2 flex items-center gap-2">
                <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                Saldo Pendiente
            </p>
            <div class="flex items-baseline gap-1">
                <span class="text-lg font-black text-red-500">S/</span>
                <p class="text-4xl font-black text-white tracking-tighter tabular-nums">
                    {{ number_format($totalPendiente, 2) }}
                </p>
            </div>
            <div class="mt-4 flex items-center justify-between text-[9px] font-bold uppercase tracking-widest">
                <span class="text-gray-600">Estado de cuenta</span>
                <span class="{{ $totalPendiente > 0 ? 'text-red-500' : 'text-green-500' }}">
                    {{ $totalPendiente > 0 ? 'Con Deuda' : 'Al día' }}
                </span>
            </div>
        </div>
    </div>
</div>