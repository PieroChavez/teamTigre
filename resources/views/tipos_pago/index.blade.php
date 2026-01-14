<x-app-layout>
    @section('header', 'Administración de Tipos de Pago')

    <div class="container mx-auto p-6">
        <div class="max-w-4xl mx-auto bg-white shadow-xl rounded-xl p-8 border border-gray-200">
            
            <div class="flex justify-between items-center mb-6 border-b pb-3">
                <h1 class="text-2xl font-extrabold text-gray-800 flex items-center gap-2">
                    <i class="fa-solid fa-credit-card text-blue-600"></i> Tipos de Pago Registrados
                </h1>
                <a href="{{ route('tipos_pago.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition">
                    <i class="fa-solid fa-plus mr-2"></i> Crear Nuevo
                </a>
            </div>

            {{-- Alertas de Sesión --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            {{-- Tabla de Tipos de Pago --}}
            <div class="overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 w-1/12">ID</th>
                            <th scope="col" class="px-6 py-3 w-8/12">Nombre del Tipo de Pago</th>
                            <th scope="col" class="px-6 py-3 w-3/12 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tiposPago as $tipoPago)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $tipoPago->id }}</td>
                                <td class="px-6 py-4">{{ $tipoPago->nombre }}</td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('tipos_pago.edit', $tipoPago) }}" 
                                       class="text-indigo-600 hover:text-indigo-900 font-semibold">
                                        Editar
                                    </a>
                                    
                                    {{-- Botón de Eliminar (Formulario) --}}
                                    <form action="{{ route('tipos_pago.destroy', $tipoPago) }}" method="POST" class="inline"
                                          onsubmit="return confirm('¿Está seguro de que desea eliminar este tipo de pago? Esta acción no se puede deshacer y fallará si existen pagos asociados.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-white border-b">
                                <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                                    No hay Tipos de Pago registrados aún.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>