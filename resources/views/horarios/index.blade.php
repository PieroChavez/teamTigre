<x-app-layout>
    {{-- Header Estilo Premium Dark --}}
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="font-black text-3xl text-white leading-tight tracking-tighter flex items-center gap-3 uppercase">
                <div class="p-2 bg-indigo-500/10 rounded-xl">
                    <i class="fa-solid fa-calendar-day text-indigo-500 shadow-sm"></i>
                </div>
                Gestión de Horarios
            </h2>
            
            <a href="{{ route('horarios.create') }}"
                class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-black uppercase tracking-widest rounded-xl transition-all duration-300 shadow-lg shadow-indigo-900/20 hover:shadow-indigo-500/40 transform hover:-translate-y-0.5">
                <i class="fa-solid fa-calendar-plus text-sm"></i>
                Crear Nuevo Horario
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-[#050505] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Alertas Estilo Premium --}}
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                     class="p-4 rounded-2xl bg-green-500/10 border border-green-500/20 text-green-400 shadow-xl flex items-center justify-between animate-fade-in">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-circle-check text-xl"></i>
                        <span class="text-sm font-bold uppercase tracking-wide">{{ session('success') }}</span>
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
            <div class="bg-[#0a0a0a] rounded-3xl border border-white/5 shadow-2xl overflow-hidden">
                <div class="p-6 border-b border-white/5 bg-white/[0.01]">
                    <h3 class="text-xs font-black text-gray-500 uppercase tracking-[0.3em] flex items-center gap-2">
                        <i class="fa-solid fa-table-list text-orange-500"></i> Lista de Clases Programadas
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full border-separate border-spacing-0">
                        <thead>
                            <tr class="bg-white/[0.02]">
                                <th class="px-6 py-5 text-left text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] border-b border-white/5">Clase / Categoría</th>
                                <th class="px-6 py-5 text-left text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] border-b border-white/5">Docente</th>
                                <th class="px-6 py-5 text-center text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] border-b border-white/5">Rango Horario</th>
                                <th class="px-6 py-5 text-left text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] border-b border-white/5">Días Programados</th>
                                <th class="px-6 py-5 text-right text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] border-b border-white/5">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/[0.03]">
                            @forelse($horarios as $h)
                                <tr class="hover:bg-white/[0.02] transition-all duration-300 group">
                                    
                                    {{-- Categoría --}}
                                    <td class="px-6 py-6 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="p-2 bg-orange-500/10 rounded-lg group-hover:bg-orange-500/20 transition-colors">
                                                <i class="fa-solid fa-chalkboard-user text-orange-500 text-xs"></i>
                                            </div>
                                            <span class="text-sm font-black text-gray-200 uppercase tracking-tight">
                                                {{ $h->categoria_nombre }}
                                            </span>
                                        </div>
                                    </td>
                                    
                                    {{-- Docente --}}
                                    <td class="px-6 py-6 whitespace-nowrap">
                                        <span class="text-xs font-bold text-gray-400 uppercase">
                                            {{ $h->docente_nombre }}
                                        </span>
                                    </td>
                                    
                                    {{-- Hora --}}
                                    <td class="px-6 py-6 whitespace-nowrap text-center">
                                        <span class="px-3 py-1.5 rounded-xl bg-indigo-500/10 border border-indigo-500/20 font-mono text-xs font-black text-indigo-400 tracking-tighter shadow-inner">
                                            {{ $h->rango_hora }}
                                        </span>
                                    </td>
                                    
                                    {{-- Días Agrupados --}}
                                    <td class="px-6 py-6 whitespace-nowrap">
                                        <div class="flex flex-wrap gap-1.5">
                                            @foreach(explode(',', $h->dias_semana) as $dia)
                                                <span class="px-2 py-0.5 text-[9px] font-black text-gray-400 bg-white/[0.03] border border-white/5 rounded-md uppercase tracking-tighter">
                                                    {{ trim($dia) }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    
                                    {{-- Acciones --}}
                                    <td class="px-6 py-6 whitespace-nowrap text-right">
                                        <div class="flex justify-end gap-2">
                                            {{-- Editar Grupo --}}
                                            <a href="{{ route('horarios.edit', $h->id) }}"
                                               title="Editar Grupo"
                                               class="p-2 bg-white/[0.03] hover:bg-orange-500/20 border border-white/5 hover:border-orange-500/50 rounded-xl text-gray-500 hover:text-orange-500 transition-all shadow-sm">
                                                <i class="fa-solid fa-pen-nib text-xs"></i>
                                            </a>

                                            {{-- Eliminar Grupo --}}
                                            <form action="{{ route('horarios.destroyGroup', $h->grupo_key) }}" method="POST" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" 
                                                        title="Eliminar Grupo Completo"
                                                        onclick="return confirm('⚠️ ¿Eliminar todo el grupo de horarios para {{ $h->categoria_nombre }}?')" 
                                                        class="p-2 bg-white/[0.03] hover:bg-red-500/20 border border-white/5 hover:border-red-500/50 rounded-xl text-gray-500 hover:text-red-500 transition-all shadow-sm">
                                                    <i class="fa-solid fa-calendar-xmark text-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center gap-3 opacity-20">
                                            <i class="fa-solid fa-calendar-xmark text-5xl text-white"></i>
                                            <p class="text-xs font-black text-white uppercase tracking-[0.3em]">Sin horarios programados</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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