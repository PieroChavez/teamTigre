<x-app-layout>
    {{-- Header Estilo Premium Dark --}}
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="font-black text-3xl text-white leading-tight tracking-tighter flex items-center gap-3 uppercase">
                <div class="p-2 bg-orange-500/10 rounded-xl">
                    <i class="fa-solid fa-layer-group text-orange-500 shadow-sm"></i>
                </div>
                Gestión de Categorías
            </h2>
            
            <a href="{{ route('categorias.create') }}"
                class="inline-flex items-center gap-2 px-6 py-3 bg-white text-black text-xs font-black uppercase tracking-widest rounded-xl transition-all duration-300 hover:bg-orange-500 hover:text-white shadow-lg transform hover:-translate-y-0.5">
                <i class="fa-solid fa-plus text-sm"></i>
                Nueva Categoría
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-[#050505] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">

            {{-- Alerta de Éxito Custom --}}
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                     class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 shadow-xl flex items-center justify-between animate-fade-in">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-circle-check text-xl"></i>
                        <span class="text-sm font-bold uppercase tracking-wide">{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="text-emerald-500/50 hover:text-emerald-500"><i class="fa-solid fa-xmark"></i></button>
                </div>
            @endif

            {{-- Grid Pro --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse ($categorias as $categoria)
                    <div class="group relative bg-[#0a0a0a] rounded-3xl border border-white/5 hover:border-orange-500/30 transition-all duration-500 shadow-2xl overflow-hidden flex flex-col justify-between">
                        
                        {{-- Decoración de fondo al hover --}}
                        <div class="absolute -right-8 -top-8 w-24 h-24 bg-orange-500/5 rounded-full blur-3xl group-hover:bg-orange-500/15 transition-all duration-500"></div>

                        <div class="p-8 relative z-10">
                            {{-- Icon Box --}}
                            <div class="w-14 h-14 bg-white/[0.03] border border-white/5 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:border-orange-500/50 transition-all duration-500">
                                <i class="fa-solid fa-shapes text-2xl text-gray-400 group-hover:text-orange-500 transition-colors"></i>
                            </div>

                            <h4 class="text-xl font-black text-white mb-3 uppercase tracking-tight group-hover:text-orange-500 transition-colors">
                                {{ $categoria->nombre }}
                            </h4>
                            
                            <p class="text-sm text-gray-500 leading-relaxed font-medium line-clamp-3">
                                {{ $categoria->descripcion ?? 'Sin descripción disponible para esta categoría de entrenamiento.' }}
                            </p>
                        </div>

                        {{-- Footer de la Tarjeta (Acciones) --}}
                        <div class="px-8 py-6 bg-white/[0.01] border-t border-white/5 flex justify-between items-center group-hover:bg-white/[0.03] transition-colors">
                            <a href="{{ route('categorias.edit', $categoria) }}"
                               class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 hover:text-white flex items-center gap-2 transition-colors">
                                <i class="fa-solid fa-pen-to-square text-orange-500"></i>
                                Editar
                            </a>

                            <form method="POST" action="{{ route('categorias.destroy', $categoria) }}" 
                                  onsubmit="return confirm('¿Eliminar definitivamente {{ $categoria->nombre }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-600 hover:text-red-500 flex items-center gap-2 transition-colors">
                                    <i class="fa-solid fa-trash-can"></i>
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 bg-[#0a0a0a] rounded-3xl border-2 border-dashed border-white/5 text-center">
                        <div class="flex flex-col items-center gap-4 opacity-20">
                            <i class="fa-solid fa-layer-group text-6xl text-white"></i>
                            <p class="text-sm font-black text-white uppercase tracking-[0.4em]">No hay categorías registradas</p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Paginación Estilizada --}}
            <div class="mt-12">
                {{ $categorias->links() }}
            </div>
            
        </div>
    </div>

    <style>
        /* Fade in para las tarjetas */
        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Clamp para que las descripciones largas no rompan el grid */
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;  
            overflow: hidden;
        }
    </style>
</x-app-layout>