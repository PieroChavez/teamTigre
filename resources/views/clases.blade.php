<x-guest-layout>
    
    <div class="p-6 lg:p-12 text-center text-gray-200 bg-gray-900 min-h-screen">
        
        <h1 class="text-5xl font-extrabold mb-4 text-orange-500 pt-10">
            Nuestras Disciplinas y Categorías
        </h1>
        <p class="text-xl mb-12 text-gray-400">
            Encuentra la especialidad de boxeo y entrenamiento que te llevará al siguiente nivel.
        </p>

        {{-- Contenedor de Categorías (Grid) --}}
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                
                {{-- ITERACIÓN DINÁMICA DE CATEGORÍAS --}}
                @forelse ($categories as $category)
                    {{-- 🌟 Card de Categoría --}}
                    <div class="bg-gray-800 p-8 rounded-xl shadow-2xl transition duration-300 transform hover:scale-[1.03] border border-gray-700 hover:border-orange-500">
                        
                        {{-- Icono/Imagen Placeholder (Ajusta la fuente del icono si lo deseas) --}}
                        <div class="p-4 inline-flex mb-4 bg-orange-500 rounded-full text-white">
                             <i class="fas fa-hand-rock text-3xl"></i> {{-- Icono de Puño --}}
                        </div>
                        
                        {{-- Nombre de la Categoría --}}
                        <h3 class="text-3xl font-bold mb-3 text-white">{{ $category->name }}</h3>
                        
                        {{-- Descripción (Asumiendo que el modelo Category tiene un campo 'description') --}}
                        <p class="text-base text-gray-400 mb-6 h-16 overflow-hidden">
                            {{ $category->description ?? 'Esta categoría agrupa entrenamientos especializados con enfoque en técnica y potencia avanzada.' }}
                        </p>

                        {{-- Detalle Rápido (ej. # de coaches, si la tienes con withCount) --}}
                        @if(isset($category->coaches_count))
                            <p class="text-sm text-gray-500 mb-6">
                                Impartido por **{{ $category->coaches_count }}** instructores expertos.
                            </p>
                        @endif

                        {{-- Botón de Acción --}}
                        <a href="{{ route('planes') }}" 
                            class="block w-full py-3 rounded-lg font-bold text-lg 
                                bg-orange-600 text-white hover:bg-orange-700 transition duration-150 shadow-lg">
                            Ver Planes Relacionados
                        </a>
                    </div>
                @empty
                    {{-- Mensaje si no hay categorías activas --}}
                    <div class="md:col-span-3 text-center p-10 bg-gray-800 rounded-lg text-gray-500 italic">
                        <i class="fas fa-info-circle mr-2"></i> No hay disciplinas de entrenamiento disponibles en este momento.
                    </div>
                @endforelse
                
            </div>
        </div>
        
    </div>

</x-guest-layout>