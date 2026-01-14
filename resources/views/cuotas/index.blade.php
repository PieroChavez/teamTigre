<x-app-layout>
    {{-- Título de la página --}}
    @section('header', 'Gestión de Cuotas y Pagos')

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg overflow-hidden">

                {{-- Encabezado de la Sección --}}
                <div class="p-6 bg-indigo-600 border-b border-indigo-700 sm:rounded-t-lg">
                    <div class="flex justify-between items-center">
                        <h2 class="text-3xl font-bold text-white flex items-center gap-3">
                            <i class="fa-solid fa-receipt"></i> Historial de Pagos
                        </h2>
                        {{-- Botón para registrar una nueva Cuota / Pago --}}
                        <a href="{{ route('cuotas.create') }}">
                            <x-primary-button class="bg-green-500 hover:bg-green-600 focus:ring-green-300">
                                <i class="fa-solid fa-plus mr-2"></i> Registrar Nuevo Pago
                            </x-primary-button>
                        </a>
                    </div>
                </div>

                {{-- Filtros y Búsqueda --}}
                <div class="p-6 border-b border-gray-200">
                    <form action="{{ route('cuotas.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                        
                        {{-- Campo de Búsqueda --}}
                        <div class="md:col-span-2">
                            <x-input-label for="search" value="Buscar por Estudiante o DNI" />
                            <x-text-input id="search" name="search" type="text" class="mt-1 block w-full" value="{{ request('search') }}" placeholder="Nombre, DNI o ID de cuota..." />
                        </div>

                        {{-- Filtro por Estado --}}
                        <div>
                            <x-input-label for="estado" value="Filtrar por Estado" />
                            <select id="estado" name="estado" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="todos" @selected(request('estado') == 'todos')>Todos los Estados</option>
                                <option value="pagado" @selected(request('estado') == 'pagado')>Pagado</option>
                                <option value="pendiente" @selected(request('estado') == 'pendiente')>Pendiente</option>
                                <option value="vencido" @selected(request('estado') == 'vencido')>Vencido</option>
                            </select>
                        </div>

                        {{-- Botón de Aplicar Filtros --}}
                        <div>
                            <x-primary-button class="w-full">
                                <i class="fa-solid fa-filter mr-2"></i> Aplicar
                            </x-primary-button>
                        </div>
                    </form>
                </div>

                {{-- Tabla de Listado de Cuotas --}}
                <div class="p-6">
                    @if ($cuotas->isEmpty())
                        <div class="p-4 bg-yellow-100 text-yellow-800 rounded-lg border border-yellow-300 text-center">
                            <i class="fa-solid fa-info-circle mr-2"></i> No se encontraron cuotas que coincidan con los filtros.
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estudiante</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Concepto / Plan</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Monto</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Venc.</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($cuotas as $cuota)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $cuota->id }}</td>
                                            
                                            {{-- Estudiante --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                                <a href="{{ route('estudiantes.show', $cuota->estudiante) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">
                                                    {{ $cuota->estudiante->user->name ?? 'N/A' }}
                                                </a>
                                                <div class="text-xs text-gray-500">DNI: {{ $cuota->estudiante->dni }}</div>
                                            </td>

                                            {{-- Concepto / Plan --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                                {{ $cuota->concepto }}
                                            </td>

                                            {{-- Monto --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-center text-green-700">
                                                {{ number_format($cuota->monto, 2) }}
                                            </td>

                                            {{-- Fecha Vencimiento --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                                {{ $cuota->fecha_vencimiento->format('d/m/Y') }}
                                            </td>

                                            {{-- Estado --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                @php
                                                    $badge = match ($cuota->estado) {
                                                        'pagado' => 'bg-green-100 text-green-800',
                                                        'pendiente' => 'bg-yellow-100 text-yellow-800',
                                                        'vencido' => 'bg-red-100 text-red-800',
                                                        default => 'bg-gray-100 text-gray-800',
                                                    };
                                                @endphp
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badge }}">
                                                    {{ ucfirst($cuota->estado) }}
                                                </span>
                                            </td>

                                            {{-- Acciones --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                <div class="flex justify-center space-x-2">
                                                    <a href="{{ route('cuotas.show', $cuota) }}" class="text-indigo-600 hover:text-indigo-900" title="Ver Detalle">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>
                                                    @if ($cuota->estado !== 'pagado')
                                                        {{-- Botón para marcar como pagado (simula un formulario de acción) --}}
                                                        <form action="{{ route('cuotas.pagar', $cuota) }}" method="POST" onsubmit="return confirm('¿Confirmar pago de esta cuota?')">
                                                            @csrf
                                                            <button type="submit" class="text-green-600 hover:text-green-900" title="Marcar como Pagado">
                                                                <i class="fa-solid fa-money-check-dollar"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Paginación --}}
                        <div class="mt-4">
                            {{ $cuotas->links() }}
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>