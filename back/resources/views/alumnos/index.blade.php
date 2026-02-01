<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="font-black text-3xl text-white leading-tight tracking-tighter flex items-center gap-3">
                <div class="p-2 bg-orange-500/10 rounded-xl">
                    <i class="fa-solid fa-users text-orange-500 shadow-sm"></i>
                </div>
                GESTIÓN DE ALUMNOS
            </h2>
            
            <a href="{{ route('alumnos.create') }}"
                class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-black uppercase tracking-widest rounded-xl transition-all duration-300 shadow-lg shadow-indigo-900/20 hover:shadow-indigo-500/40 transform hover:-translate-y-0.5">
                <i class="fa-solid fa-plus text-sm"></i>
                Nuevo Alumno
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-[#050505] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Alertas Estilo Premium --}}
            @if (session('success') || session('status'))
                <div class="p-4 rounded-2xl bg-green-500/10 border border-green-500/20 text-green-400 shadow-xl flex items-center gap-3 animate-fade-in">
                    <i class="fa-solid fa-circle-check text-xl"></i>
                    <span class="text-sm font-bold uppercase tracking-wide">{{ session('success') ?? session('status') }}</span>
                </div>
            @endif

            {{-- Card Principal (Contenedor de Tabla) --}}
            <div class="bg-[#0a0a0a] rounded-3xl border border-white/5 shadow-2xl overflow-hidden mt-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full border-separate border-spacing-0">
                        <thead>
                            <tr class="bg-white/[0.02]">
                                <th class="px-6 py-5 text-left text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] border-b border-white/5">ID</th>
                                <th class="px-6 py-5 text-left text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] border-b border-white/5">Alumno / Código</th>
                                <th class="px-6 py-5 text-left text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] border-b border-white/5 hidden sm:table-cell">Contacto</th>
                                <th class="px-6 py-5 text-left text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] border-b border-white/5 hidden md:table-cell">Ingreso</th>
                                <th class="px-6 py-5 text-left text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] border-b border-white/5 text-center">Estado</th>
                                <th class="px-6 py-5 text-right text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] border-b border-white/5">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/[0.03]">
                            @forelse ($alumnos as $alumno)
                                <tr class="hover:bg-white/[0.02] transition-all duration-300 cursor-pointer group"
                                    onclick="window.location='{{ route('alumnos.show', $alumno->id) }}'">
                                    
                                    <td class="px-6 py-6 whitespace-nowrap">
                                        <span class="text-sm font-mono text-gray-600 font-bold">#{{ $alumno->id }}</span>
                                    </td>
                                    
                                    <td class="px-6 py-6 whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-black text-gray-200 group-hover:text-orange-500 transition-colors uppercase">
                                                {{ $alumno->user->name ?? 'Usuario Eliminado' }}
                                            </span>
                                            <span class="text-[10px] font-mono text-indigo-500/70 tracking-tighter">
                                                {{ $alumno->codigo_barra }}
                                            </span>
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-6 whitespace-nowrap hidden sm:table-cell">
                                        <div class="flex items-center gap-2 text-gray-400">
                                            <i class="fa-solid fa-envelope text-[10px] text-gray-600"></i>
                                            <span class="text-xs font-medium">{{ $alumno->user->email ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-6 whitespace-nowrap hidden md:table-cell">
                                        <span class="text-xs font-bold text-gray-500 uppercase tracking-widest">
                                            {{ $alumno->fecha_ingreso?->format('d M, Y') ?? '---' }}
                                        </span>
                                    </td>
                                    
                                    <td class="px-6 py-6 whitespace-nowrap text-center">
                                        @php
                                            $badgeColor = match ($alumno->estado) {
                                                'activo' => 'bg-green-500/10 text-green-500 border-green-500/20',
                                                'inactivo' => 'bg-red-500/10 text-red-500 border-red-500/20',
                                                'suspendido' => 'bg-orange-500/10 text-orange-500 border-orange-500/20',
                                                default => 'bg-gray-500/10 text-gray-500 border-gray-500/20',
                                            };
                                        @endphp
                                        <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest border {{ $badgeColor }}">
                                            {{ $alumno->estado }}
                                        </span>
                                    </td>
                                    
                                    <td class="px-6 py-6 whitespace-nowrap text-right">
                                        <div class="flex justify-end gap-2" onclick="event.stopPropagation()">
                                            {{-- Botón Editar --}}
                                            <a href="{{ route('alumnos.edit', $alumno->id) }}" 
                                               class="p-2 bg-white/[0.03] hover:bg-orange-500/20 border border-white/5 hover:border-orange-500/50 rounded-xl text-gray-500 hover:text-orange-500 transition-all shadow-sm">
                                                <i class="fa-solid fa-pen-nib text-xs"></i>
                                            </a>

                                            {{-- Botón Eliminar --}}
                                            <form action="{{ route('alumnos.destroy', $alumno->id) }}" method="POST" 
                                                  onsubmit="return confirm('¿Eliminar registro definitivo?');" class="inline">
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
                                        <div class="flex flex-col items-center gap-3">
                                            <i class="fa-solid fa-ghost text-4xl text-white/5"></i>
                                            <p class="text-xs font-black text-gray-600 uppercase tracking-[0.3em]">No hay alumnos registrados</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginación Personalizada Dark --}}
                @if ($alumnos->hasPages())
                    <div class="px-6 py-6 bg-white/[0.01] border-t border-white/5">
                        {{ $alumnos->links() }}
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