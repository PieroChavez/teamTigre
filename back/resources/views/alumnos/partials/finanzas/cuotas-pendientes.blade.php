{{-- Cuotas Pendientes - Estilo Dark Premium --}}
@php
    $cuotasPendientes = $todasLasCuotas
        ->filter(fn ($c) => ($c->monto_pendiente ?? 0) > 0.01)
        ->sortBy('fecha_programada');
@endphp

<div class="bg-[#1a1a1a] shadow-2xl rounded-2xl p-6 border border-orange-500/10 relative overflow-hidden group">
    {{-- Efecto de luz de fondo --}}
    <div class="absolute -top-12 -left-12 w-24 h-24 bg-orange-600/5 rounded-full blur-2xl transition-all group-hover:bg-orange-600/10"></div>

    <div class="flex justify-between items-center border-b border-white/5 pb-4 mb-6">
        <h2 class="text-xs font-black text-white uppercase tracking-[0.3em] flex items-center">
            <span class="relative flex h-2 w-2 mr-3">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-orange-500"></span>
            </span>
            Pagos Pendientes
        </h2>

        <a href="{{ route('cuotas.createForAlumno', $alumno->id) }}"
           class="px-3 py-1.5 bg-[#222] text-[9px] text-orange-500 border border-orange-500/20 rounded-lg font-black uppercase tracking-widest hover:bg-orange-600 hover:text-white transition-all duration-300 shadow-lg">
            <i class="fa-solid fa-plus mr-1"></i> Cuota Extra
        </a>
    </div>

    @if ($cuotasPendientes->isEmpty())
        <div class="py-10 text-center">
            <div class="inline-flex items-center justify-center w-12 h-12 bg-green-500/10 rounded-full mb-3 text-green-500">
                <i class="fa-solid fa-check-double text-xl"></i>
            </div>
            <p class="text-gray-500 italic text-xs uppercase tracking-widest font-bold">Atleta al día con sus cuentas</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-[9px] font-black text-gray-600 uppercase tracking-[0.2em] border-b border-white/5">
                        <th class="px-3 py-3 text-left font-black">Concepto</th>
                        <th class="px-3 py-3 text-right font-black">Total</th>
                        <th class="px-3 py-3 text-right font-black">Faltante</th>
                        <th class="px-3 py-3 text-center font-black">Vencimiento</th>
                        <th class="px-3 py-3 text-right font-black">Acción</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-white/[0.03]">
                    @foreach ($cuotasPendientes as $cuota)
                        @php
                            $inscripcionId = optional($cuota->cuentaInscripcion)->inscripcion_id ?? 0;
                            $porcentaje = min(100, max(0, round($cuota->porcentaje_pagado ?? 0)));
                            $vencida = $cuota->fecha_programada?->isPast();
                        @endphp

                        <tr class="group/row hover:bg-white/[0.02] transition-colors">
                            <td class="px-3 py-4">
                                <div class="text-sm font-black text-white uppercase tracking-tighter">{{ $cuota->concepto ?? 'Cuota General' }}</div>
                                {{-- Progress Bar Mini --}}
                                <div class="w-full max-w-[100px] bg-white/5 h-1 mt-2 rounded-full overflow-hidden">
                                    <div class="bg-orange-500 h-full rounded-full transition-all duration-700 shadow-[0_0_8px_rgba(249,115,22,0.5)]" 
                                         style="width: {{ $porcentaje }}%"></div>
                                </div>
                            </td>

                            <td class="px-3 py-4 text-right font-bold text-gray-500 text-xs tabular-nums">
                                S/{{ number_format($cuota->monto, 2) }}
                            </td>

                            <td class="px-3 py-4 text-right font-black text-red-500 tabular-nums">
                                S/{{ number_format($cuota->monto_pendiente, 2) }}
                            </td>

                            <td class="px-3 py-4 text-center">
                                <span class="text-[10px] font-black {{ $vencida ? 'text-red-600 animate-pulse' : 'text-gray-400' }}">
                                    {{ $cuota->fecha_programada?->format('d/m/Y') ?? '-' }}
                                </span>
                            </td>

                            <td class="px-3 py-4 text-right">
                                <button @click="
                                            montoPago='{{ number_format($cuota->monto_pendiente, 2, '.', '') }}';
                                            inscripcionId='{{ $inscripcionId }}';
                                            openPagoModal=true;
                                        "
                                        class="inline-flex items-center gap-2 px-4 py-2 bg-orange-600 hover:bg-orange-500 text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-[0_5px_15px_rgba(234,88,12,0.2)]">
                                    <i class="fa-solid fa-hand-holding-dollar"></i>
                                    Pagar
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>