<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Gestión de Categorías') }}
                </h2>
                <p class="text-sm text-gray-500">Administra las disciplinas y especialidades de tu centro</p>
            </div>
            
            <a href="{{ route('admin.categories.create') }}" 
                class="inline-flex items-center justify-center px-6 py-3 bg-indigo-600 border border-transparent rounded-2xl font-bold text-sm text-white tracking-wide hover:bg-indigo-700 shadow-xl shadow-indigo-100 transition duration-150 ease-in-out">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Nueva Categoría
            </a>
        </div>
    </x-slot>

    <div 
        x-data="{ 
            show: {{ session('success') || session('error') ? 'true' : 'false' }}, 
            message: '{{ session('success') ?? session('error') }}',
            type: '{{ session('success') ? 'success' : (session('error') ? 'error' : '') }}'
        }" 
        x-init="
            if(show) {
                setTimeout(() => show = false, 10000) // Desaparece después de 10 segundos
            }
        "
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-4 sm:translate-y-0 sm:scale-90"
        x-transition:enter-end="opacity-100 transform translate-y-0 sm:scale-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 transform translate-y-4 sm:translate-y-0 sm:scale-90"
        class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4 fixed inset-x-0 top-16 z-50 pointer-events-none"
    >
        <div :class="{
            'bg-red-100 border-red-400 text-red-700': type === 'error',
            'bg-green-100 border-green-400 text-green-700': type === 'success',
        }" class="border-l-4 p-4 rounded-xl shadow-lg flex items-center justify-between mx-auto max-w-lg pointer-events-auto">
            <p x-text="message" class="font-medium"></p>
            <button @click="show = false" class="text-sm font-semibold ml-4" aria-label="Cerrar">
                &times;
            </button>
        </div>
    </div>
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- GRID DE CATEGORÍAS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($categories as $category)
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 hover:shadow-xl hover:shadow-gray-100 transition-all duration-300 group">
                        <div class="flex items-start justify-between mb-4">
                            <div class="p-3 bg-indigo-50 rounded-2xl text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            
                            {{-- Badge de Conteo (Si tienes la relación establecida) --}}
                            @if(isset($category->coaches_count))
                                <span class="bg-gray-100 text-gray-600 text-xs font-bold px-3 py-1 rounded-full">
                                    {{ $category->coaches_count }} Coaches
                                </span>
                            @endif
                        </div>

                        <h3 class="text-xl font-extrabold text-gray-800 mb-2 truncate">
                            {{ $category->name }}
                        </h3>
                        
                        <p class="text-sm text-gray-500 mb-6">Especialidad activa en el sistema para asignación de entrenamientos.</p>

                        <div class="flex flex-col gap-2">
                            {{-- ACCIÓN PRINCIPAL: ASIGNAR --}}
                            <a href="{{ route('admin.categories.coaches.edit', $category) }}" 
                                class="flex items-center justify-center w-full px-4 py-2 bg-purple-50 text-purple-700 rounded-xl font-bold text-sm hover:bg-purple-100 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                Gestionar Coaches
                            </a>

                            <div class="flex items-center gap-2">
                                {{-- EDITAR --}}
                                <a href="{{ route('admin.categories.edit', $category) }}" 
                                    class="flex-1 flex items-center justify-center px-4 py-2 bg-gray-50 text-gray-600 rounded-xl font-bold text-sm hover:bg-gray-100 transition-colors">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                    Editar
                                </a>

                                {{-- ELIMINAR --}}
                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="flex-1">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" 
                                        onclick="return confirm('¿Estás seguro de eliminar esta categoría? Si hay coaches asignados, la eliminación será rechazada.')"
                                        class="w-full flex items-center justify-center px-4 py-2 bg-red-50 text-red-600 rounded-xl font-bold text-sm hover:bg-red-100 transition-colors">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Borrar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($categories->isEmpty())
                <div class="bg-white rounded-3xl p-12 text-center border-2 border-dashed border-gray-200">
                    <div class="mx-auto w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mb-4 text-gray-300">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">No hay categorías registradas</h3>
                    <p class="text-gray-500 mb-6">Comienza creando una categoría para organizar a tus coaches.</p>
                    <a href="{{ route('admin.categories.create') }}" class="text-indigo-600 font-bold hover:underline">Crear mi primera categoría</a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>