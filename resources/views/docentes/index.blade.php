<x-app-layout>
    {{-- Header Estilo Premium Dark --}}
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="font-black text-3xl text-white leading-tight tracking-tighter flex items-center gap-3 uppercase">
                <div class="p-2 bg-orange-500/10 rounded-xl">
                    <i class="fa-solid fa-chalkboard-teacher text-orange-500 shadow-sm"></i>
                </div>
                Gestión de Docentes
            </h2>
            
            <a href="{{ route('docentes.create') }}"
                class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-black uppercase tracking-widest rounded-xl transition-all duration-300 shadow-lg shadow-indigo-900/20 hover:shadow-indigo-500/40 transform hover:-translate-y-0.5">
                <i class="fa-solid fa-user-plus text-sm"></i>
                Nuevo Docente
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

            {{-- Card Principal (Contenedor de Tabla Dark) --}}
            <div class="bg-[#0a0a0a] rounded-3xl border border-white/5 shadow-2xl overflow-hidden mt-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full border-separate border-spacing-0">
                        <thead>
                            <tr class="bg-white/[0.02]">
                                <th class="px-6 py-5 text-left text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] border-b border-white/5">DNI</th>
                                <th class="px-6 py-5 text-left text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] border-b border-white/5">Docente</th>
                                <th class="px-6 py-5 text-left text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] border-b border-white/5 hidden sm:table-cell">Especialidad</th>
                                <th class="px-6 py-5 text-left text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] border-b border-white/5 hidden md:table-cell">Contacto</th>
                                <th class="px-6 py-5 text-center text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] border-b border-white/5">Estado</th>
                                <th class="px-6 py-5 text-right text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] border-b border-white/5">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/[0.03]">
                            @forelse ($docentes as $docente)
                                <tr class="hover:bg-white/[0.02] transition-all duration-300 cursor-pointer group"
                                    onclick="window.location='{{ route('docentes.show', $docente->id) }}'">
                                    
                                    <td class="px-6 py-6 whitespace-nowrap">
                                        <span class="text-sm font-mono text-gray-600 font-bold tracking-tighter">{{ $docente->dni }}</span>
                                    </td>
                                    
                                    <td class="px-6 py-6 whitespace-nowrap">
                                        <div class="flex items-center gap-4">
                                            <div class="h-10 w-10 rounded-xl bg-orange-500/10 border border-orange-500/20 flex items-center justify-center text-orange-500 font-black text-xs group-hover:bg-orange-500 group-hover:text-white transition-all duration-300">
                                                {{ substr($docente->user->name, 0, 1) }}
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-sm font-black text-gray-200 group-hover:text-orange-500 transition-colors uppercase">
                                                    {{ $docente->user->name }}
                                                </span>
                                                <span class="text-[10px] font-mono text-indigo-500/70 tracking-tighter">
                                                    {{ $docente->user->email }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-6 whitespace-nowrap hidden sm:table-cell">
                                        <span class="px-3 py-1 rounded-lg bg-white/[0.03] border border-white/5 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                            {{ $docente->especialidad }}
                                        </span>
                                    </td>
                                    
                                    <td class="px-6 py-6 whitespace-nowrap hidden md:table-cell">
                                        <div class="flex items-center gap-2 text-gray-400">
                                            <i class="fa-solid fa-phone text-[10px] text-gray-600"></i>
                                            <span class="text-xs font-medium">{{ $docente->telefono ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-6 whitespace-nowrap text-center">
                                        @php
                                            $isActive = $docente->estado === 'activo';
                                            $badgeStyle = $isActive 
                                                ? 'bg-green-500/10 text-green-500 border-green-500/20' 
                                                : 'bg-rose-500/10 text-rose-500 border-rose-500/20';
                                        @endphp
                                        <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest border {{ $badgeStyle }}">
                                            <span class="inline-block w-1.5 h-1.5 rounded-full mr-1.5 {{ $isActive ? 'bg-green-500 animate-pulse' : 'bg-rose-500' }}"></span>
                                            {{ $docente->estado }}
                                        </span>
                                    </td>
                                    
                                    <td class="px-6 py-6 whitespace-nowrap text-right">
                                        <div class="flex justify-end gap-2" onclick="event.stopPropagation()">
                                            {{-- Botón Editar --}}
                                            <a href="{{ route('docentes.edit', $docente->id) }}" 
                                               class="p-2 bg-white/[0.03] hover:bg-orange-500/20 border border-white/5 hover:border-orange-500/50 rounded-xl text-gray-500 hover:text-orange-500 transition-all shadow-sm">
                                                <i class="fa-solid fa-pen-nib text-xs"></i>
                                            </a>

                                            {{-- Botón Eliminar --}}
                                            <form action="{{ route('docentes.destroy', $docente->id) }}" method="POST" 
                                                  onsubmit="return confirm('¿Eliminar docente?');" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" 
                                                        class="p-2 bg-white/[0.03] hover:bg-rose-500/20 border border-white/5 hover:border-rose-500/50 rounded-xl text-gray-500 hover:text-rose-500 transition-all shadow-sm">
                                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <i class="fa-solid fa-user-slash text-4xl text-white/5"></i>
                                            <p class="text-xs font-black text-gray-600 uppercase tracking-[0.3em]">No hay docentes registrados</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginación Personalizada --}}
                @if ($docentes->hasPages())
                    <div class="px-6 py-6 bg-white/[0.01] border-t border-white/5">
                        {{ $docentes->links() }}
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