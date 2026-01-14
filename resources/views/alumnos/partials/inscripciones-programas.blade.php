{{-- resources/views/alumnos/partials/inscripciones-programas.blade.php --}}

@php
    $moneda = 'S/';
@endphp

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-white/10 pb-4 mb-6 gap-4">
    
    {{-- TÍTULO DE LA SECCIÓN --}}
    <h2 class="text-xs font-black text-orange-500 uppercase tracking-[0.3em] flex items-center gap-3">
        <i class="fa-solid fa-graduation-cap text-lg"></i> Inscripciones y Programas
    </h2>
    
    {{-- ⭐ BOTÓN DE ACCIÓN: INSCRIBIR A UN PROGRAMA --}}
    <a href="{{ route('inscripciones.create', ['alumno_id' => $alumno->id]) }}"
        class="inline-flex items-center px-4 py-2 bg-orange-600 hover:bg-orange-500 text-white text-[10px] font-black uppercase tracking-widest rounded-lg shadow-[0_0_15px_rgba(234,88,12,0.3)] transition-all duration-300">
        <i class="fa-solid fa-plus-circle mr-2"></i> Inscribir a Programa
    </a>
</div>

@if($alumno->inscripciones->isEmpty())
    <div class="py-10 flex flex-col items-center justify-center text-center border-2 border-dashed border-white/5 rounded-2xl">
        <i class="fa-solid fa-folder-open text-3xl text-white/5 mb-3"></i>
        <p class="text-gray-500 italic text-sm">Este alumno no tiene inscripciones registradas.</p>
    </div>
@else
    <div class="space-y-4">
        @foreach($alumno->inscripciones->sortByDesc('fecha_inicio') as $inscripcion)
            @php
                $hasDebtAccount = $inscripcion->cuentasInscripcion->isNotEmpty();
                $isVigente = $inscripcion->estado === 'vigente';
            @endphp
            
            <div x-data="{ open: false }" 
                 class="group rounded-2xl overflow-hidden border transition-all duration-300 
                        {{ $isVigente ? 'border-orange-600/30 bg-orange-600/5' : 'border-white/5 bg-[#141414]' }}"> 
                
                {{-- CABECERA DE LA TARJETA --}}
                <div class="p-4 flex justify-between items-center">
                    
                    <div class="flex-grow">
                        <div class="flex items-center gap-3">
                            <p class="font-black text-white uppercase tracking-tighter text-base">
                                {{ $inscripcion->categoria->nombre ?? 'N/A' }} 
                            </p>
                            <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">
                                • {{ $inscripcion->periodo->nombre ?? 'S/P' }}
                            </span>
                        </div>
                        
                        <div class="flex flex-wrap gap-x-4 gap-y-1 mt-2">
                            <p class="text-[11px] text-gray-400 font-medium flex items-center gap-1">
                                <i class="fa-solid fa-calendar-day text-orange-500/70"></i> 
                                {{ $inscripcion->fecha_inicio?->format('d/m/Y') }} — {{ $inscripcion->fecha_fin?->format('d/m/Y') }}
                            </p>
                            @if ($hasDebtAccount)
                                <p class="text-[11px] text-orange-400 font-bold flex items-center gap-1">
                                    <i class="fa-solid fa-file-invoice-dollar"></i> Cuenta Activa
                                </p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="flex flex-col items-end gap-3 ml-4">
                        <span class="px-3 py-1 text-[9px] font-black uppercase tracking-tighter rounded-full
                            {{ $isVigente ? 'bg-orange-600 text-white shadow-[0_0_10px_rgba(234,88,12,0.4)]' : 'bg-white/5 text-gray-500' }}">
                            {{ $inscripcion->estado }}
                        </span>
                        
                        <button @click="open = !open"
                                class="text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-white transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-chevron-down transition-transform duration-300" :class="{'rotate-180': open}"></i>
                            <span x-text="open ? 'Cerrar' : 'Detalles'">Detalles</span>
                        </button>
                    </div>
                </div>
                
                {{-- DETALLES DESPLEGABLES --}}
                <div x-show="open" 
                     x-collapse
                     x-cloak
                     class="px-5 pb-5 pt-2 border-t border-white/5 bg-black/20">
                     
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-2">
                        <div class="space-y-2">
                            <p class="text-xs text-gray-500 uppercase tracking-widest font-bold">Programa</p>
                            <p class="text-sm text-white font-medium">{{ $inscripcion->programa->nombre ?? 'N/A' }}</p>
                        </div>
                        <div class="space-y-2">
                            <p class="text-xs text-gray-500 uppercase tracking-widest font-bold">Inversión Total</p>
                            <p class="text-sm text-orange-500 font-black">{{ $moneda }}{{ number_format($inscripcion->costo_total, 2) }}</p>
                        </div>
                        <div class="space-y-2">
                            <p class="text-xs text-gray-500 uppercase tracking-widest font-bold">Modalidad</p>
                            <p class="text-sm text-gray-300">{{ $inscripcion->modalidad_pago ?? 'N/A' }}</p>
                        </div>
                        <div class="space-y-2">
                            <p class="text-xs text-gray-500 uppercase tracking-widest font-bold">Registro</p>
                            <p class="text-sm text-gray-300">{{ $inscripcion->created_at?->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    
                    <div class="mt-6 pt-4 border-t border-white/5 flex justify-end">
                         <a href="{{ route('inscripciones.edit', $inscripcion->id) }}"
                            class="text-[10px] font-black text-gray-400 hover:text-orange-500 uppercase tracking-widest transition-all flex items-center gap-2">
                            <i class="fa-solid fa-pen-to-square"></i> Editar Inscripción
                         </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif