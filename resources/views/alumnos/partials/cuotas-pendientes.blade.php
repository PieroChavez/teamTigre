{{-- Historial de Cuotas - Estilo Dark Premium --}}
<div class="bg-[#1a1a1a] shadow-2xl rounded-2xl p-6 border border-white/5 transition-all duration-300">
    <h3 class="text-[10px] font-black text-orange-500 uppercase tracking-[0.3em] border-b border-white/10 pb-4 flex items-center gap-3">
        <i class="fa-solid fa-bell text-lg"></i> Control de Cuotas y Vencimientos
    </h3>

    @php
        // Obtenemos las cuotas desde la relación del alumno
        $cuotas = $alumno->cuotaPagos; 
    @endphp

    @if($cuotas->isEmpty())
        <div class="py-12 flex flex-col items-center justify-center text-center">
            <i class="fa-solid fa-layer-group text-3xl text-white/5 mb-3"></i>
            <p class="text-gray-500 italic text-sm">No hay cuotas registradas para este atleta.</p>
        </div>
    @else
        <div class="overflow-x-auto mt-6 custom-scrollbar">
            <table class="min-w-full border-separate border-spacing-y-2">
                <thead>
                    <tr class="text-[9px] font-black text-gray-500 uppercase tracking-[0.2em]">
                        <th class="px-4 py-2 text-left">ID</th>
                        <th class="px-4 py-2 text-left">Concepto</th>
                        <th class="px-4 py-2 text-right">Monto</th>
                        <th class="px-4 py-2 text-right">Pagado</th>
                        <th class="px-4 py-2 text-left pl-8">Vencimiento</th>
                        <th class="px-4 py-2 text-center">Estado</th>
                        <th class="px-4 py-2 text-right">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cuotas as $cuota) 
                        @php
                            $isPagado = $cuota->estado === 'pagado';
                            $isPendiente = $cuota->estado === 'pendiente';
                            
                            $borderClass = match ($cuota->estado) {
                                'pagado' => 'border-green-500/20 group-hover:border-green-500/50',
                                'pendiente' => 'border-orange-500/20 group-hover:border-orange-500/50',
                                default => 'border-red-500/20 group-hover:border-red-500/50',
                            };

                            $statusDot = match ($cuota->estado) {
                                'pagado' => 'bg-green-500',
                                'pendiente' => 'bg-orange-500',
                                default => 'bg-red-500',
                            };
                        @endphp
                        <tr class="group transition-all duration-300">
                            {{-- ID --}}
                            <td class="bg-[#141414] px-4 py-3 rounded-l-xl border-y border-l {{ $borderClass }} text-[11px] font-bold text-gray-600">
                                #{{ $cuota->id }}
                            </td>

                            {{-- Concepto --}}
                            <td class="bg-[#141414] px-4 py-3 border-y {{ $borderClass }}">
                                <span class="text-sm font-black text-white uppercase tracking-tighter">
                                    {{ $cuota->concepto }}
                                </span>
                            </td>

                            {{-- Monto Total --}}
                            <td class="bg-[#141414] px-4 py-3 border-y {{ $borderClass }} text-right font-black text-gray-300 text-sm">
                                {{ $moneda ?? 'S/' }}{{ number_format($cuota->monto, 2) }}
                            </td>

                            {{-- Monto Pagado --}}
                            <td class="bg-[#141414] px-4 py-3 border-y {{ $borderClass }} text-right font-black text-green-500 text-sm">
                                {{ $moneda ?? 'S/' }}{{ number_format($cuota->monto_pagado, 2) }}
                            </td>

                            {{-- Vencimiento --}}
                            <td class="bg-[#141414] px-4 py-3 border-y {{ $borderClass }} pl-8">
                                <span class="text-[10px] font-bold text-gray-400">
                                    <i class="fa-solid fa-calendar-day mr-1 opacity-50"></i>
                                    {{ $cuota->fecha_vencimiento?->format('d/m/Y') ?? '-' }}
                                </span>
                            </td>

                            {{-- Estado --}}
                            <td class="bg-[#141414] px-4 py-3 border-y {{ $borderClass }} text-center">
                                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-black/40 border border-white/5">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $statusDot }} animate-pulse"></span>
                                    <span class="text-[9px] font-black uppercase tracking-widest {{ $isPagado ? 'text-green-500' : ($isPendiente ? 'text-orange-500' : 'text-red-500') }}">
                                        {{ $cuota->estado }}
                                    </span>
                                </div>
                            </td>

                            {{-- Acciones --}}
                            <td class="bg-[#141414] px-4 py-3 rounded-r-xl border-y border-r {{ $borderClass }} text-right">
                                @if($isPagado)
                                    <a href="{{ route('cuotas.recibo', $cuota->id) }}" 
                                       class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/5 hover:bg-white/10 text-white rounded-lg text-[10px] font-black uppercase tracking-tighter transition-all">
                                        <i class="fa-solid fa-file-invoice-dollar text-orange-500"></i> Recibo
                                    </a>
                                @else
                                    <span class="text-[9px] font-black text-gray-700 uppercase tracking-tighter">No disp.</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>