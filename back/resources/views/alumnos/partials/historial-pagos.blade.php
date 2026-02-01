{{-- Historial de Pagos - Estilo Dark Premium --}}
<div class="bg-[#1a1a1a] shadow-2xl rounded-2xl p-6 border border-white/5 transition-all duration-300">
    <h3 class="text-xs font-black text-orange-500 uppercase tracking-[0.3em] border-b border-white/10 pb-4 flex items-center gap-3">
        <i class="fa-solid fa-receipt text-xl"></i> Historial de Pagos Realizados
    </h3>

    <div class="space-y-3 max-h-72 overflow-y-auto pr-2 mt-6 custom-scrollbar">
        @php
            // Se asume que $alumno->pagos() devuelve una Collection o Builder.
            $pagos = $alumno->pagos()->sortByDesc('fecha_pago'); 
        @endphp

        @forelse($pagos as $pago)
            <div class="flex justify-between items-center bg-[#141414] rounded-xl p-4 hover:bg-black hover:border-orange-500/30 transition-all duration-300 border border-white/5 group">
                <div class="flex flex-col gap-1">
                    {{-- Concepto del pago --}}
                    <p class="font-black text-white text-sm uppercase tracking-tight group-hover:text-orange-500 transition-colors">
                        {{ $pago->conceptoPago->nombre ?? $pago->concepto ?? 'Pago General de Academia' }}
                    </p>
                    
                    {{-- Detalles: FECHA Y MÉTODO --}}
                    <div class="flex items-center gap-4 text-[11px] text-gray-500 font-bold uppercase tracking-widest">
                        <span class="flex items-center gap-1">
                            <i class="fa-solid fa-calendar-check text-orange-500/70"></i> 
                            {{ $pago->fecha_pago?->format('d/m/Y H:i') ?? $pago->created_at->format('d/m/Y H:i') }}
                        </span>
                        <span class="flex items-center gap-1">
                            <i class="fa-solid fa-credit-card text-orange-500/70"></i> 
                            {{ optional($pago->tipoPago)->nombre ?? 'N/A' }}
                        </span>
                    </div>
                </div>

                {{-- Monto con estilo resaltado --}}
                <div class="text-right">
                    <span class="text-lg font-black text-white group-hover:text-orange-500 transition-colors">
                        {{ $moneda ?? 'S/' }}{{ number_format($pago->monto, 2) }}
                    </span>
                    <p class="text-[9px] text-gray-600 font-black uppercase tracking-tighter">Confirmado</p>
                </div>
            </div>
        @empty
            <div class="py-12 flex flex-col items-center justify-center border-2 border-dashed border-white/5 rounded-2xl">
                <i class="fa-solid fa-receipt text-3xl text-white/5 mb-3"></i>
                <p class="text-gray-500 italic text-sm">No hay pagos registrados para este alumno.</p>
            </div>
        @endforelse
    </div>
</div>

{{-- Estilo para el scrollbar personalizado --}}
<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(234, 88, 12, 0.2);
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgba(234, 88, 12, 0.5);
    }
</style>