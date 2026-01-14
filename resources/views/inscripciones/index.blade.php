<x-app-layout>
    {{-- Header Estilo Premium Dark --}}
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="font-black text-3xl text-white leading-tight tracking-tighter flex items-center gap-3 uppercase">
                <div class="p-2 bg-emerald-500/10 rounded-xl">
                    <i class="fa-solid fa-file-signature text-emerald-500 shadow-sm"></i>
                </div>
                Gestión de Inscripciones
            </h2>
            
            <a href="{{ route('inscripciones.create') }}"
                class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-black uppercase tracking-widest rounded-xl transition-all duration-300 shadow-lg shadow-indigo-900/20 hover:shadow-indigo-500/40 transform hover:-translate-y-0.5">
                <i class="fa-solid fa-plus-circle text-sm"></i>
                Nueva Inscripción
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-[#050505] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Alertas Estilo Premium --}}
            @if (session('success') || session('status'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                     class="p-4 rounded-2xl bg-green-500/10 border border-green-500/20 text-green-400 shadow-xl flex items-center justify-between animate-fade-in">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-circle-check text-xl"></i>
                        <span class="text-sm font-bold uppercase tracking-wide">{{ session('success') ?? session('status') }}</span>
                    </div>
                    <button @click="show = false" class="text-green-500/50 hover:text-green-500"><i class="fa-solid fa-xmark"></i></button>
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-400 shadow-xl flex items-center gap-3 animate-fade-in">
                    <i class="fa-solid fa-triangle-exclamation text-xl"></i>
                    <span class="text-sm font-bold uppercase tracking-wide">{{ session('error') }}</span>
                </div>
            @endif

            {{-- Card Principal (Contenedor de Tabla Dark) --}}
            <div class="bg-[#0a0a0a] rounded-3xl border border-white/5 shadow-2xl overflow-hidden mt-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full border-separate border-spacing-0">
                        <thead>
                            <tr class="bg-white/[0.02]">
                                <th class="px-6 py-5 text-left text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] border-b border-white/5">Alumno</th>
                                <th class="px-6 py-5 text-left text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] border-b border-white/5 uppercase">Categoría / Curso</th>
                                <th class="px-6 py-5 text-left text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] border-b border-white/5 hidden sm:table-cell">Periodo</th>
                                <th class="px-6 py-5 text-left text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] border-b border-white/5 hidden md:table-cell tracking-tighter">Fecha Inscr.</th>
                                <th class="px-6 py-5 text-center text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] border-b border-white/5">Estado</th>
                                <th class="px-6 py-5 text-right text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] border-b border-white/5">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/[0.03]">
                            @forelse ($inscripciones as $inscripcion)
                                <tr class="hover:bg-white/[0.02] transition-all duration-300 group cursor-pointer"
                                    onclick="window.location='{{ route('inscripciones.edit', $inscripcion->id) }}'">
                                    
                                    {{-- Alumno --}}
                                    <td class="px-6 py-6 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="h-9 w-9 rounded-lg bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-indigo-400 font-black text-xs group-hover:bg-indigo-600 group-hover:text-white transition-all">
                                                {{ substr($inscripcion->alumno->user->name, 0, 1) }}
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-sm font-black text-gray-200 group-hover:text-orange-500 transition-colors uppercase">
                                                    {{ $inscripcion->alumno->user->name }}
                                                </span>
                                                <span class="text-[9px] font-mono text-gray-600 uppercase tracking-tighter italic">Ver Perfil</span>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    {{-- Categoría --}}
                                    <td class="px-6 py-6 whitespace-nowrap">
                                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">
                                            {{ $inscripcion->categoria->nombre ?? 'Sin Categoría' }}
                                        </span>
                                    </td>
                                    
                                    {{-- Periodo --}}
                                    <td class="px-6 py-6 whitespace-nowrap hidden sm:table-cell">
                                        <span class="px-3 py-1 rounded-lg bg-white/[0.03] border border-white/5 text-[10px] font-black text-indigo-500 uppercase tracking-widest">
                                            {{ $inscripcion->periodo->nombre ?? 'N/A' }}
                                        </span>
                                    </td>
                                    
                                    {{-- Fecha --}}
                                    <td class="px-6 py-6 whitespace-nowrap hidden md:table-cell">
                                        <div class="flex items-center gap-2 text-gray-500 font-mono text-xs">
                                            <i class="fa-regular fa-calendar-check text-[10px]"></i>
                                            {{ $inscripcion->fecha_inscripcion?->format('d M, Y') ?? '---' }}
                                        </div>
                                    </td>
                                    
                                    {{-- Estado --}}
                                    <td class="px-6 py-6 whitespace-nowrap text-center">
                                        @php
                                            $badgeColor = match ($inscripcion->estado) {
                                                'vigente' => 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20',
                                                'finalizado' => 'bg-blue-500/10 text-blue-500 border-blue-500/20',
                                                default => 'bg-amber-500/10 text-amber-500 border-amber-500/20',
                                            };
                                        @endphp
                                        <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest border {{ $badgeColor }}">
                                            {{ $inscripcion->estado }}
                                        </span>
                                    </td>
                                    
                                    {{-- Acciones --}}
                                    <td class="px-6 py-6 whitespace-nowrap text-right">
                                        <div class="flex justify-end gap-2" onclick="event.stopPropagation()">
                                            <a href="{{ route('inscripciones.edit', $inscripcion->id) }}" 
                                               class="p-2 bg-white/[0.03] hover:bg-orange-500/20 border border-white/5 hover:border-orange-500/50 rounded-xl text-gray-500 hover:text-orange-500 transition-all shadow-sm">
                                                <i class="fa-solid fa-edit text-xs"></i>
                                            </a>

                                            <form action="{{ route('inscripciones.destroy', $inscripcion->id) }}" method="POST" 
                                                  onsubmit="return confirm('¿Eliminar inscripción definitiva?');" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" 
                                                        class="p-2 bg-white/[0.03] hover:bg-red-500/20 border border-white/5 hover:border-red-500/50 rounded-xl text-gray-500 hover:text-red-500 transition-all shadow-sm">
                                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center gap-3 opacity-20">
                                            <i class="fa-solid fa-folder-open text-5xl text-white"></i>
                                            <p class="text-xs font-black text-white uppercase tracking-[0.3em]">No hay inscripciones registradas</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginación Dark --}}
                @if ($inscripciones->hasPages())
                    <div class="px-6 py-6 bg-white/[0.01] border-t border-white/5">
                        {{ $inscripciones->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</x-app-layout>