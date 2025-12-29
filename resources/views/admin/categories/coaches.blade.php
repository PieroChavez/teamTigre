<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.categories.index') }}" class="text-gray-400 hover:text-indigo-600 transition-colors">
                        <i class="fas fa-arrow-left text-xl"></i>
                    </a>
                    <h2 class="font-bold text-3xl text-gray-800 leading-tight">
                        {{ __('Asignación de Personal') }}
                    </h2>
                </div>
                <p class="text-md text-gray-600 ml-8 mt-1">
                    <i class="fas fa-folder-open mr-1 text-indigo-500"></i>
                    Gestionando coaches para: <span class="font-extrabold text-indigo-700">{{ $category->name }}</span>
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- MENSAJE DE ÉXITO --}}
            @if (session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-400 text-green-700 p-4 rounded-lg shadow-sm" role="alert">
                    <p class="font-bold">{{ session('success') }}</p>
                </div>
            @endif
            
            <div class="bg-white shadow-2xl border border-gray-100 sm:rounded-xl overflow-hidden">
                <div class="p-8 md:p-10">
                    
                    <div class="flex items-center space-x-3 mb-8 pb-4 border-b border-gray-100">
                        <i class="fas fa-user-tie text-2xl text-indigo-600"></i>
                        <h3 class="text-xl font-extrabold text-gray-800">Seleccionar Coaches Disponibles</h3>
                    </div>

                    <form method="POST" action="{{ route('admin.categories.coaches.update', $category) }}" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 gap-3">
                            @forelse ($coaches as $coach)
                                {{-- TARJETA DE COACH --}}
                                <label class="relative flex items-center p-4 rounded-xl border-2 transition-all duration-200 cursor-pointer 
                                    bg-white hover:bg-indigo-50/50 hover:shadow-md
                                    @if($category->coaches->contains($coach->id)) border-indigo-300 shadow-lg @else border-gray-100 @endif
                                    peer-checked:border-indigo-600 peer-checked:shadow-lg">

                                    {{-- Checkbox oculto funcional --}}
                                    <input type="checkbox"
                                           name="coaches[]"
                                           value="{{ $coach->id }}"
                                           @checked($category->coaches->contains($coach->id))
                                           class="peer sr-only">

                                    <div class="flex items-center w-full gap-4">
                                        {{-- Avatar --}}
                                        <div class="w-12 h-12 rounded-full flex items-center justify-center font-extrabold text-white text-lg transition-all shadow-md
                                            @if($category->coaches->contains($coach->id)) bg-indigo-600 @else bg-gray-300 @endif
                                            peer-checked:bg-indigo-600 peer-checked:scale-105">
                                            {{ strtoupper(substr($coach->user->name, 0, 2)) }}
                                        </div>

                                        <div class="flex-1">
                                            <p class="text-base font-bold text-gray-800">{{ $coach->user->name }}</p>
                                            <p class="text-sm text-gray-500">{{ $coach->user->email }}</p>
                                        </div>

                                        {{-- Círculo de selección --}}
                                        <div class="w-6 h-6 rounded-full border-2 border-gray-300 flex items-center justify-center transition-all 
                                            peer-checked:border-indigo-600 peer-checked:bg-indigo-600 peer-checked:scale-110">
                                            <svg class="w-4 h-4 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </label>
                            @empty
                                <div class="text-center py-10 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                                    <p class="text-gray-500 font-medium mb-3">
                                        <i class="fas fa-exclamation-circle mr-2"></i> No hay coaches registrados en el sistema.
                                    </p>
                                    <a href="{{ route('admin.coaches.create') }}" class="text-indigo-600 font-bold text-sm hover:underline">
                                        <i class="fas fa-user-plus mr-1"></i> Registrar un coach ahora
                                    </a>
                                </div>
                            @endforelse
                        </div>

                        {{-- ACCIONES --}}
                        <div class="flex flex-col md:flex-row items-center justify-between pt-8 border-t border-gray-100 gap-4 mt-10">
                            <p class="text-xs text-gray-500">
                                <span class="font-extrabold text-indigo-500 uppercase tracking-tight">Recuerda:</span> 
                                Al guardar, solo los coaches seleccionados tendrán acceso a la gestión de alumnos de esta categoría.
                            </p>
                            
                            <div class="flex items-center gap-4 w-full md:w-auto">
                                <a href="{{ route('admin.categories.index') }}" class="flex-1 md:flex-none text-center text-sm font-bold text-gray-500 hover:text-gray-700 transition-colors uppercase tracking-wide py-3 px-6">
                                    Cancelar
                                </a>
                                <button type="submit" class="flex-1 md:flex-none inline-flex justify-center items-center px-8 py-3 bg-indigo-600 border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-widest hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition duration-150">
                                    <i class="fas fa-check-circle w-4 h-4 mr-2"></i>
                                    {{ __('Guardar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
