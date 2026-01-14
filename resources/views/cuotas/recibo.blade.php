<x-app-layout>
    @section('header', 'Comprobante de Pago')

    <div class="container mx-auto p-4 sm:p-6">
        <div class="max-w-xl mx-auto bg-white text-gray-800 rounded-xl shadow-2xl p-8 border border-gray-100" id="receipt-print-area">

            {{-- Encabezado y Número de Serie --}}
            <div class="flex justify-between items-start mb-8 border-b border-gray-200 pb-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-indigo-700">RECIBO DE PAGO</h1>
                    <p class="text-sm text-gray-500 mt-1">Academia Boxeo</p>
                </div>
                <div class="text-right">
                    {{-- Usaremos el ID de la Cuota como referencia del recibo --}}
                    <p class="text-xs text-gray-500 uppercase">Referencia de Cuota</p>
                    <p class="text-2xl font-black text-gray-900">#{{ str_pad($cuotaPago->id, 6, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>

            {{-- Datos del Alumno --}}
            <div class="mb-6 p-4 bg-indigo-50/50 rounded-lg border border-indigo-100">
                <h2 class="text-lg font-bold text-indigo-700 mb-2 flex items-center gap-2">
                    <i class="fa-solid fa-user-graduate"></i> Datos del Alumno
                </h2>
                <div class="grid grid-cols-2 gap-x-6 text-sm">
                    <div>
                        <p class="text-gray-500">Nombre:</p>
                        <p class="font-semibold">{{ optional($cuotaPago->cuentaInscripcion->alumno->user)->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Código:</p>
                        <p class="font-semibold">{{ $cuotaPago->cuentaInscripcion->alumno->codigo_barra }}</p>
                    </div>
                    <div class="mt-2 col-span-2">
                        <p class="text-gray-500">Estado:</p>
                        <span class="px-2 py-0.5 rounded-full text-xs font-bold @if(strtolower($cuotaPago->cuentaInscripcion->alumno->estado) === 'activo') bg-green-100 text-green-800 @else bg-yellow-100 text-yellow-800 @endif">
                            {{ ucfirst($cuotaPago->cuentaInscripcion->alumno->estado) }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Detalles de la Cuota/Venta --}}
            <div class="mb-6">
                <h2 class="text-lg font-bold text-gray-800 mb-3 border-b border-gray-200 pb-2 flex items-center gap-2">
                    <i class="fa-solid fa-file-invoice"></i> Desglose de Pagos
                </h2>
                
                {{-- DESGLOSE DE PAGOS INDIVIDUALES --}}
                @foreach ($cuotaPago->pagos->sortBy('fecha_pago') as $pago)
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between border-b border-dashed pb-1">
                            <span class="font-medium text-gray-600">Concepto (Cuota):</span>
                            <span class="font-semibold text-gray-900">{{ $cuotaPago->concepto }}</span>
                        </div>
                        <div class="flex justify-between border-b border-dashed pb-1">
                            <span class="font-medium text-gray-600">Referencia de Pago:</span>
                            <span class="font-semibold text-gray-900">{{ str_pad($pago->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="flex justify-between border-b border-dashed pb-1">
                            <span class="font-medium text-gray-600">Fecha de Transacción:</span>
                            <span class="font-semibold text-gray-900">{{ $pago->fecha_pago?->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between border-b border-dashed pb-1">
                            <span class="font-medium text-gray-600">Método de Pago:</span>
                            <span class="font-semibold text-gray-900">{{ optional($pago->tipoPago)->nombre ?? 'N/A' }}</span>
                        </div>
                        @if ($pago->referencia)
                            <div class="flex justify-between border-b border-dashed pb-1">
                                <span class="font-medium text-gray-600">Detalle de Ref.:</span>
                                <span class="font-semibold text-gray-900">{{ $pago->referencia }}</span>
                            </div>
                        @endif

                        {{-- MONTO DE ESTA TRANSACCIÓN --}}
                        <div class="flex justify-between items-center bg-gray-50 py-2 mt-2 mb-4 rounded">
                            <span class="text-lg font-bold text-gray-700">MONTO DE ESTE RECIBO:</span>
                            <span class="text-2xl font-extrabold text-green-700">${{ number_format($pago->monto, 2) }}</span>
                        </div>
                        <hr class="my-4 border-gray-200">
                    </div>
                @endforeach
            </div>

            {{-- Resumen de la Cuota (Solo si hubo pagos parciales) --}}
            @if ($cuotaPago->pagos->count() > 1)
                <div class="border-t border-gray-200 pt-4 mt-6">
                    <div class="flex justify-between items-center text-sm">
                        <span class="font-medium text-gray-600">Monto Original de la Cuota:</span>
                        <span class="font-semibold">${{ number_format($cuotaPago->monto, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="font-medium text-gray-600">Total Pagado a la Fecha:</span>
                        <span class="font-semibold text-green-700">${{ number_format($cuotaPago->monto_pagado, 2) }}</span>
                    </div>
                </div>
            @endif
            
             {{-- Pie de Recibo --}}
            <div class="text-center pt-6 text-xs text-gray-500 border-t border-gray-200 mt-6">
                <p>GRACIAS POR SU PAGO. <br>Comprobante generado el {{ now()->format('d/m/Y H:i') }}</p>
            </div>

        </div>

        {{-- Botones de Acción --}}
        <div class="max-w-xl mx-auto pt-6 text-center print:hidden flex justify-center gap-4">
             <button onclick="window.print()" 
                class="px-5 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition-colors shadow-md flex items-center gap-2">
                <i class="fa-solid fa-print"></i> Imprimir Comprobante
            </button>
            <a href="{{ route('alumnos.show', $cuotaPago->cuentaInscripcion->alumno_id) }}"
               class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition-colors shadow-md flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Volver al Alumno
            </a>
        </div>
    </div>
</x-app-layout>