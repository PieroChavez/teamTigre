{{-- resources/views/planes.blade.php --}}

<x-guest-layout>
    
    <div class="p-6 lg:p-12 text-center text-gray-200 bg-gray-900 min-h-screen">
        
        <h1 class="text-5xl font-extrabold mb-4 text-orange-500 pt-10">
            Nuestros Planes de Entrenamiento
        </h1>
        <p class="text-xl mb-12 text-gray-400">
            Elige el plan que mejor se adapte a tu ritmo y objetivos de entrenamiento.
        </p>

        {{-- Contenedor de Planes (Tabla de precios) --}}
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-3 lg:gap-12">
                
                {{-- ITERACIÓN DINÁMICA DE PLANES --}}
                @forelse ($plans as $plan)
                    <div class="bg-gray-800 p-8 rounded-xl shadow-2xl transition duration-300 transform hover:scale-[1.05] border border-gray-700 relative 
                        {{ $loop->iteration == 2 ? 'border-4 border-orange-500' : '' }}">
                        
                        {{-- Etiqueta de Recomendado (ejemplo, para el segundo plan) --}}
                        @if ($loop->iteration == 2)
                            <div class="absolute top-0 right-0 -mt-3 -mr-3 px-3 py-1 bg-orange-500 text-sm font-bold rounded-full shadow-lg text-white">
                                MÁS POPULAR
                            </div>
                        @endif

                        <h3 class="text-3xl font-bold mb-3 text-white">{{ $plan->name }}</h3>
                        <p class="text-sm text-gray-400 mb-6">{{ $plan->duration_days }} días de boxeo</p>

                        {{-- Precio --}}
                        <div class="text-5xl font-extrabold mb-6">
                            <span class="text-orange-500">S/{{ number_format($plan->price, 0) }}</span>
                            <span class="text-gray-400 text-lg font-normal">/{{ $plan->duration_days == 30 ? 'mes' : 'período' }}</span>
                        </div>

                        {{-- Lista de Características (Esto puede ser fijo o dinámico si tu modelo Plan tiene un campo JSON/array) --}}
                        <ul class="text-left space-y-3 mb-8 text-gray-300">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-orange-500 mr-2 mt-1"></i> <span>Acceso a todas las clases grupales.</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-orange-500 mr-2 mt-1"></i> <span>Entrenamiento de alta intensidad.</span>
                            </li>
                            {{-- Ejemplo de característica condicional --}}
                            @if($plan->duration_days >= 30) 
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-orange-500 mr-2 mt-1"></i> <span>Monitoreo de progreso mensual.</span>
                            </li>
                            @endif
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-orange-500 mr-2 mt-1"></i> <span>Soporte de instructores certificados.</span>
                            </li>
                        </ul>

                        {{-- Botón de Acción --}}
                        {{-- Usamos la URL directa '/register' para evitar problemas de RouteNotFound --}}
                        <a href="/register" 
                            class="block w-full py-3 rounded-lg font-bold text-lg 
                                {{ $loop->iteration == 2 ? 'bg-orange-500 text-white hover:bg-orange-600' : 'bg-gray-700 text-gray-200 hover:bg-gray-600' }} 
                                transition duration-150 shadow-lg">
                            ¡Inscríbete Ahora!
                        </a>
                    </div>
                @empty
                    {{-- Mensaje si no hay planes activos --}}
                    <div class="md:col-span-3 text-center p-10 bg-gray-800 rounded-lg text-gray-500 italic">
                        <i class="fas fa-info-circle mr-2"></i> Actualmente no tenemos planes activos publicados. Por favor, vuelve más tarde.
                    </div>
                @endforelse
                
            </div>
        </div>
        
    </div>

</x-guest-layout>