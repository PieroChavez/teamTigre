<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Mi Historial de Pagos') }}
                </h2>
                <p class="text-sm text-gray-500">Administra y revisa todos tus recibos y transacciones</p>
            </div>
            <a href="{{ route('student.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Volver al Portal
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if ($payments->isEmpty())
                <div class="bg-white rounded-3xl p-12 text-center shadow-sm border border-gray-100">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-50 text-blue-500 rounded-full mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Sin pagos registrados</h3>
                    <p class="text-gray-500">Aún no tienes transacciones en tu cuenta.</p>
                </div>
            @else
                <div class="bg-white shadow-sm border border-gray-100 overflow-hidden sm:rounded-2xl">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-gray-50/50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Fecha</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Concepto</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Monto</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-wider">Método</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-wider">Estado</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach ($payments as $payment)
                                    @php
                                        // Traducción de Estados
                                        $statusMap = [
                                            'paid' => ['label' => 'Pagado', 'style' => 'bg-green-100 text-green-700'],
                                            'pending' => ['label' => 'Pendiente', 'style' => 'bg-amber-100 text-amber-700'],
                                            'expired' => ['label' => 'Vencido', 'style' => 'bg-red-100 text-red-700'],
                                        ];
                                        $currentStatus = $statusMap[$payment->status] ?? ['label' => 'Desconocido', 'style' => 'bg-gray-100 text-gray-600'];

                                        // Traducción de Métodos
                                        $methodMap = [
                                            'cash' => 'Efectivo',
                                            'transfer' => 'Transferencia',
                                            'card' => 'Tarjeta',
                                            'yape' => 'Yape',
                                            'plin' => 'Plin',
                                        ];
                                        $methodLabel = $methodMap[$payment->method] ?? $payment->method;
                                    @endphp

                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-5 whitespace-nowrap text-sm text-gray-600">
                                            {{ \Carbon\Carbon::parse($payment->created_at)->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-5">
                                            <div class="text-sm font-bold text-gray-900">
                                                {{ $payment->enrollment->category->name ?? 'Clase' }}
                                            </div>
                                            <div class="text-xs text-gray-400">
                                                Plan: {{ $payment->plan->name ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <span class="text-sm font-black text-gray-900">
                                                S/ {{ number_format($payment->amount, 2) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap text-center text-sm text-gray-600">
                                            <span class="px-2 py-1 bg-gray-100 rounded text-xs font-medium">
                                                {{ $methodLabel }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap text-center">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full uppercase tracking-widest {{ $currentStatus['style'] }}">
                                                {{ $currentStatus['label'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <div class="mt-6 p-4 bg-indigo-50 rounded-2xl border border-indigo-100 flex items-start space-x-3">
                <svg class="w-5 h-5 text-indigo-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-sm text-indigo-700">
                    Si tienes alguna duda sobre tus pagos o necesitas una factura electrónica, por favor acércate a recepción o contáctanos por WhatsApp.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>