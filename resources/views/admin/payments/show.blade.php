<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalle del Pago #{{ $payment->id }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Botón Volver y Botón Imprimir --}}
            <div class="flex justify-between items-center mb-4 print:hidden">
                <a href="{{ route('admin.payments.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Volver al Historial
                </a>
                
                {{-- Botón para Imprimir el Recibo --}}
                <button onclick="window.print()" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-1 px-3 rounded text-sm transition">
                    Imprimir Recibo
                </button>
            </div>

            {{-- COMIENZO DEL RECIBO/BOLETA (Área de Impresión Limpia) --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8 border border-gray-300">
                
                {{-- Encabezado del Recibo (Nombre y Logo de la Escuela) --}}
                <div class="flex justify-between items-start mb-8 border-b pb-4">
                    
                    {{-- LOGO INTEGRADO USANDO asset('favicon.png') --}}
                    <img src="{{ asset('favicon.png') }}" alt="Logo El Tigre" class="w-20 h-20 object-contain mr-4">
                    
                    <div class="flex-1">
                        <h1 class="text-3xl font-extrabold text-indigo-700">Escuela de Box "El Tigre"</h1>
                        <p class="text-sm text-gray-600">Recibo de Pago por Membresía</p>
                    </div>

                    <div class="text-right">
                        <p class="text-xl font-bold text-gray-800">BOLETA N° {{ $payment->id }}</p>
                        <p class="text-sm text-gray-500 mt-1">
                            Fecha de Emisión: {{ $payment->created_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    
                    {{-- Bloque 1: DATOS DEL ALUMNO --}}
                    <div class="md:col-span-1 border-r pr-4">
                        <h4 class="text-md font-bold text-gray-700 mb-2 border-b">Recibido de:</h4>
                        <p class="text-lg font-semibold text-gray-900">{{ $payment->enrollment->student->name ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-600">ID Inscripción: {{ $payment->enrollment_id }}</p>
                        <p class="text-sm text-gray-600">Categoría: {{ $payment->enrollment->category->name ?? 'N/A' }}</p>
                    </div>

                    {{-- Bloque 2: DETALLES DE LA TRANSACCIÓN --}}
                    <div class="md:col-span-2">
                        <h4 class="text-md font-bold text-gray-700 mb-2 border-b">Concepto del Pago</h4>

                        <div class="flex justify-between text-gray-700 py-1">
                            <span class="font-medium">Plan/Servicio:</span>
                            <span>{{ $payment->plan->name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between text-gray-700 py-1">
                            <span class="font-medium">Método de Pago:</span>
                            <span class="capitalize">{{ __($payment->method) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-700 py-1">
                            <span class="font-medium">Fecha de Confirmación:</span>
                            <span>{{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('d/m/Y H:i') : 'PENDIENTE' }}</span>
                        </div>
                        
                        {{-- MONTO TOTAL (Destacado) --}}
                        <div class="flex justify-between items-center mt-4 pt-4 border-t-2 border-dashed border-gray-300">
                            <span class="text-xl font-bold text-gray-800">MONTO TOTAL:</span>
                            <span class="text-3xl font-extrabold text-green-600">S/ {{ number_format($payment->amount, 2) }}</span>
                        </div>

                        {{-- ESTADO --}}
                        <div class="mt-4 flex justify-end">
                            @php
                                $status = $payment->status;
                                $statusColor = match($status) {
                                    'paid' => 'bg-green-100 text-green-700',
                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                    'expired' => 'bg-red-100 text-red-700',
                                    'cancelled' => 'bg-gray-400 text-white',
                                    default => 'bg-gray-100 text-gray-700',
                                };
                            @endphp
                            <span class="px-4 py-1 text-base leading-6 font-bold rounded-md {{ $statusColor }} capitalize">
                                Estado: {{ __($status) }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Pie de Página / Mensaje --}}
                <div class="mt-10 text-center text-sm text-gray-500 border-t pt-4">
                    <p>Gracias por tu pago. Si tienes alguna duda, contacta a la administración de la Escuela de Box "El Tigre".</p>
                </div>

            </div>
            {{-- FIN DEL RECIBO/BOLETA --}}

            {{-- ❌ ACCIONES ELIMINADAS (No se muestra el botón Anular ni Editar) --}}

        </div>
    </div>
</x-app-layout>