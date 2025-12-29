<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            <i class="fas fa-money-check-alt mr-2"></i> {{ __('Gestión de Planes y Precios') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Sección de Mensajes de Sesión --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Éxito:</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Error:</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            {{-- Botón para crear nuevo plan --}}
            <div class="flex justify-end mb-4">
                <a href="{{ route('admin.plans.create') }}" 
                    class="inline-flex items-center px-6 py-2 bg-green-600 border border-transparent rounded-lg font-bold text-sm text-white tracking-wide hover:bg-green-700 transition duration-150 ease-in-out shadow-lg">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Crear Nuevo Plan
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Nombre del Plan</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Duración (Días)</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Precio</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 w-1/5 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($plans as $plan)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                    {{ $plan->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">
                                    {{ $plan->duration_days }} días
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-bold text-green-700">
                                    S/ {{ number_format($plan->price, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $plan->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $plan->active ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                
                                {{-- SECCIÓN DE ACCIONES MEJORADA --}}
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                    <div class="flex items-center justify-center space-x-2">
                                        {{-- Botón Editar --}}
                                        <a href="{{ route('admin.plans.edit', $plan) }}" 
                                            class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-indigo-600 bg-indigo-50 hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150" 
                                            title="Editar Plan">
                                            <i class="fas fa-edit mr-1"></i>
                                            Editar
                                        </a>

                                        {{-- Botón Eliminar --}}
                                        <form action="{{ route('admin.plans.destroy', $plan) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar el plan {{ $plan->name }}? Esta acción es irreversible.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-red-600 bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150" 
                                                title="Eliminar Plan">
                                                <i class="fas fa-trash-alt mr-1"></i>
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                {{-- FIN SECCIÓN DE ACCIONES MEJORADA --}}
                                
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500 bg-white italic">
                                    <i class="fas fa-info-circle mr-2"></i> No se encontraron planes registrados. ¡Crea el primero para comenzar a inscribir alumnos!
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        @if ($plans->isNotEmpty())
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="5" class="px-6 py-2 text-right text-xs text-gray-500">
                                        Total de planes: {{ $plans->count() }}
                                    </td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>