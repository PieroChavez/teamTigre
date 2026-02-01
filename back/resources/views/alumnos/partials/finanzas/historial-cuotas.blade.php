{{-- Historial Completo de Cuotas - Estilo Dark Premium --}}

<div class="bg-[#1a1a1a] shadow-2xl rounded-2xl p-6 border border-white/5 relative overflow-hidden">
    {{-- Glow Decorativo --}}
    <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-600/5 blur-3xl rounded-full"></div>

    <h2 class="text-xs font-black text-orange-500 border-b border-white/10 pb-4 flex items-center gap-3 uppercase tracking-[0.3em]">
        <i class="fa-solid fa-list-check text-lg"></i> Auditoría de Pagos y Deudas
    </h2>

    @if ($todasLasCuotas->isEmpty())
        <div class="py-20 flex flex-col items-center justify-center text-center opacity-50">
            <i class="fa-solid fa-box-open text-4xl mb-4 text-gray-700"></i>
            <p class="text-gray-500 italic text-sm tracking-widest uppercase font-bold">No existen registros de cobro.</p>
        </div>
    @else
        <div class="overflow-x-auto mt-6 rounded-xl border border-white/5 bg-black/20 custom-scrollbar max-h-[600px] overflow-y-auto">
            <table class="min-w-full border-separate border-spacing-0">
                <thead class="sticky top-0 z-20 bg-[#111] shadow-xl">
                    <tr class="text-[9px] font-black text-gray-500 uppercase tracking-[0.2em]">
                        <th class="px-6 py-4 text-left border-b border-white/10">Concepto y Vencimiento</th>
                        <th class="px-6 py-4 text-right border-b border-white/10">Original</th>
                        <th class="px-6 py-4 text-right border-b border-white/10 text-green-500/80">Pagado</th>
                        <th class="px-6 py-4 text-right border-b border-white/10 text-red-500/80">Pendiente</th>
                        <th class="px-6 py-4 text-center border-b border-white/10">Estado</th>
                        <th class="px-6 py-4 text-left border-b border-white/10">Historial de Transacciones</th> 
                    </tr>
                </thead>

                <tbody class="divide-y divide-white/[0.03]">
                    @foreach ($todasLasCuotas->sortByDesc('fecha_programada') as $cuota)
                        @php
                            $vencimiento = $cuota->fecha_programada ?? null;
                            $estaVencida = $cuota->monto_pendiente > 0.01 && $vencimiento && $vencimiento->isPast();
                            $esPagado = $cuota->monto_pendiente <= 0.01;
                            
                            $claseEstado = $esPagado 
                                ? 'bg-green-500/10 text-green-500 border-green-500/20' 
                                : 'bg-orange-500/10 text-orange-500 border-orange-500/20';
                        @endphp
                        
                        <tr class="group hover:bg-white/[0.02] transition-colors">
                            {{-- Concepto --}}
                            <td class="px-6 py-5">
                                <div class="text-sm font-black text-white uppercase tracking-tighter">
                                    {{ $cuota->concepto ?? 'Cuota General' }}
                                </div>
                                @if ($vencimiento)
                                    <div class="text-[10px] mt-1 font-bold flex items-center gap-1.5 {{ $estaVencida ? 'text-red-500 animate-pulse' : 'text-gray-500' }}">
                                        <i class="fa-solid fa-calendar-day opacity-50"></i>
                                        VENCE: {{ $vencimiento->format('d/m/Y') }}
                                    </div>
                                @endif
                            </td>

                            {{-- Monto Original --}}
                            <td class="px-6 py-5 text-right font-black text-gray-400 text-sm">
                                <span class="text-[10px] mr-0.5">S/</span>{{ number_format($cuota->monto, 2) }}
                            </td>

                            {{-- Monto Pagado --}}
                            <td class="px-6 py-5 text-right font-black text-green-500 text-sm">
                                <span class="text-[10px] mr-0.5 opacity-50 text-white">S/</span>{{ number_format($cuota->monto_pagado_total, 2) }}
                            </td>

                            {{-- Saldo Pendiente --}}
                            <td class="px-6 py-5 text-right font-black text-sm">
                                <span class="{{ $cuota->monto_pendiente > 0.01 ? 'text-red-500' : 'text-gray-600' }}">
                                    <span class="text-[10px] mr-0.5">S/</span>{{ number_format($cuota->monto_pendiente, 2) }}
                                </span>
                            </td>

                            {{-- Estado --}}
                            <td class="px-6 py-5 text-center">
                                <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest border {{ $claseEstado }}">
                                    {{ $esPagado ? 'PAGADO' : 'PENDIENTE' }}
                                </span>
                            </td>

                            {{-- Historial de Transacciones --}}
                            <td class="px-6 py-5">
                                <div class="flex flex-wrap gap-2 max-w-[250px]">
                                    @forelse ($cuota->pagos as $pago) 
                                        <div class="group/pago relative flex items-center bg-[#111] border border-white/5 hover:border-orange-500/50 p-2 rounded-lg transition-all">
                                            <div class="flex flex-col pr-8">
                                                <span class="text-[10px] font-black text-white leading-none">
                                                    S/{{ number_format($pago->monto, 2) }}
                                                </span>
                                                <span class="text-[8px] font-bold text-gray-600 uppercase mt-1">
                                                    {{ $pago->created_at->format('d/m H:i') }}
                                                </span>
                                            </div>
                                            <a href="{{ route('pagos.imprimir_recibo', $pago->id) }}"
                                               target="_blank"
                                               class="absolute right-2 top-1/2 -translate-y-1/2 w-6 h-6 flex items-center justify-center bg-orange-600/10 hover:bg-orange-600 text-orange-500 hover:text-white rounded-md transition-all">
                                                <i class="fa-solid fa-print text-[10px]"></i>
                                            </a>
                                        </div>
                                    @empty
                                        <span class="text-[9px] font-black text-gray-700 uppercase italic tracking-tighter">Sin abonos</span>
                                    @endforelse
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>