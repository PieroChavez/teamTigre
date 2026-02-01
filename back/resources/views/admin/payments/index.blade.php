<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            <i class="fas fa-money-check-alt mr-2"></i> {{ __('Gestión de Pagos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- BLOQUE DE ALERTAS DE ÉXITO/ERROR --}}
            @if (session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md" role="alert">
                    <p class="font-bold">¡Éxito!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md" role="alert">
                    <p class="font-bold">¡Error de Validación!</p>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            {{-- FORMULARIO DE REGISTRO RÁPIDO DE PAGO --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-8">
                <div class="p-6 lg:p-8 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-cash-register mr-2 text-indigo-600"></i> {{ __('Registrar Nuevo Pago Rápido') }}
                    </h3>

                    <form method="POST" action="{{ route('admin.payments.store') }}">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-6 gap-4 items-end">
                            
                            {{-- ALUMNO --}}
                            <div class="md:col-span-2">
                                <label for="enrollment_id" class="block text-sm font-medium text-gray-700">Inscripción / Alumno</label>
                                <select name="enrollment_id" id="enrollment_id" required 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('enrollment_id') border-red-500 @enderror">
                                    <option value="" data-amount="0">Seleccione Inscripción (Alumno - Clase)</option>
                                    
                                    @isset($enrollments)
                                        @foreach($enrollments as $enrollment)
                                            {{-- Se asume que la relación plan está cargada --}}
                                            <option 
                                                value="{{ $enrollment->id }}" 
                                                data-amount="{{ $enrollment->plan->price ?? 0 }}" 
                                                @selected(old('enrollment_id', request('enrollment_id')) == $enrollment->id)
                                            >
                                                {{ $enrollment->studentProfile->user->name ?? 'Alumno N/A' }} - {{ $enrollment->category->name ?? 'Clase N/A' }} (S/ {{ number_format($enrollment->plan->price ?? 0, 2) }})
                                            </option>
                                        @endforeach
                                    @endisset
                                </select>
                                @error('enrollment_id') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- MONTO --}}
                            <div class="md:col-span-1">
                                <label for="amount" class="block text-sm font-medium text-gray-700">Monto (S/)</label>
                                <input type="number" step="0.01" name="amount" id="amount" required value="{{ old('amount') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('amount') border-red-500 @enderror">
                                @error('amount') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- MÉTODO --}}
                            <div class="md:col-span-1">
                                <label for="method" class="block text-sm font-medium text-gray-700">Método</label>
                                <select name="method" id="method" required 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('method') border-red-500 @enderror">
                                    
                                    {{-- El uso de old('method') mantendrá el valor seleccionado después de un error de validación --}}
                                    <option value="cash" @selected(old('method') == 'cash')>Efectivo</option>
                                    <option value="yape" @selected(old('method') == 'yape')>Yape</option>
                                    <option value="transfer" @selected(old('method') == 'transfer')>Transferencia</option>
                                    <option value="card" @selected(old('method') == 'card')>Tarjeta</option>
                                </select>
                                @error('method') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- FECHA DE PAGO --}}
                            <div class="md:col-span-1">
                                <label for="paid_at" class="block text-sm font-medium text-gray-700">Fecha de Pago</label>
                                <input type="date" name="paid_at" id="paid_at" required value="{{ old('paid_at', now()->format('Y-m-d')) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('paid_at') border-red-500 @enderror">
                                @error('paid_at') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- BOTÓN --}}
                            <div class="md:col-span-1">
                                <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 transition font-bold shadow-md">
                                    <i class="fas fa-hand-holding-usd mr-1"></i> Registrar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- HISTORIAL DE TRANSACCIONES --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2 flex items-center">
                        <i class="fas fa-history mr-2 text-gray-600"></i> {{ __('Historial de Todas las Transacciones') }}
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Alumno</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Clase / Plan</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Monto (S/)</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Método</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Fecha Pagada</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Estado</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($payments as $payment)
                                    @php
                                        $status = $payment->status;

                                        // Traducción de estados
                                        $statusText = match($status) {
                                            'paid' => 'Pagado',
                                            'pending' => 'Pendiente',
                                            'expired' => 'Vencido',
                                            'cancelled' => 'Anulado',
                                            default => $status,
                                        };

                                        $statusColor = match($status) {
                                            'paid' => 'bg-green-100 text-green-700',
                                            'pending' => 'bg-yellow-100 text-yellow-700',
                                            'expired' => 'bg-red-100 text-red-700',
                                            'cancelled' => 'bg-gray-400 text-gray-900',
                                            default => 'bg-gray-100 text-gray-700',
                                        };

                                        // Accediendo a las relaciones (asumiendo que están cargadas)
                                        $studentName = $payment->enrollment->studentProfile->user->name ?? 'N/A';
                                        $className = $payment->enrollment->category->name ?? 'N/A';
                                        $planName = $payment->enrollment->plan->name ?? 'Plan N/A';
                                    @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 font-medium">
                                            {{ $payment->id }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-medium">
                                            {{ $studentName }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">
                                            {{ $className }} ({{ $planName }})
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-bold text-green-700">
                                            S/ {{ number_format($payment->amount, 2) }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-center text-sm text-gray-700 capitalize">
                                            {{ __($payment->method) }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">
                                            {{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('d/m/Y') : 'Pendiente' }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-center">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $statusColor }}">
                                                {{ $statusText }}
                                            </span>
                                        </td>
                                        {{-- COLUMNA DE ACCIONES --}}
                                        <td class="px-4 py-3 whitespace-nowrap text-center text-sm font-medium flex items-center justify-center space-x-2">
                                            <a href="{{ route('admin.payments.show', $payment) }}" class="text-indigo-600 hover:text-indigo-900 font-medium" title="Ver Detalles">
                                                <i class="fas fa-eye"></i> Detalles
                                            </a>
                                            
                                            {{-- Botón de ANULAR (Visible solo si el estado no es 'cancelled' o 'expired') --}}
                                            @if ($payment->status === 'paid' || $payment->status === 'pending')
                                                <form method="POST" action="{{ route('admin.payments.destroy', $payment) }}" onsubmit="return confirm('¿Está seguro de anular el Pago #{{ $payment->id }}? Esto podría afectar la membresía si el pago estaba completado.');" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 ml-2 font-medium" title="Anular Pago">
                                                        <i class="fas fa-times-circle"></i> Anular
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="px-4 py-6 text-center text-sm text-gray-500 bg-gray-50">
                                            <i class="fas fa-info-circle mr-2"></i> No se encontraron pagos registrados en el sistema.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    **{{-- 🎯 COMPONENTE DE PAGINACIÓN DE LARAVEL --}}**
                    <div class="mt-6">
                        {{ $payments->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPTS PARA AUTOMATIZAR EL MONTO --}}
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const enrollmentSelect = document.getElementById('enrollment_id');
            const amountInput = document.getElementById('amount');
            const initialOldAmount = amountInput.value; // Captura el valor 'old' si existe

            function updateAmount() {
                if (enrollmentSelect.selectedIndex === -1 || enrollmentSelect.value === "") {
                    amountInput.value = 0.00.toFixed(2);
                    return;
                }
                const selectedOption = enrollmentSelect.options[enrollmentSelect.selectedIndex];
                const amount = parseFloat(selectedOption.getAttribute('data-amount')) || 0;
                amountInput.value = amount.toFixed(2);
            }

            // 1. Manejar el cambio de selección
            enrollmentSelect.addEventListener('change', updateAmount);

            // 2. Ejecutar al cargar, si no hay un valor 'old' o si es el valor por defecto vacío
            // y si hay un valor seleccionado (ya sea por old() o por request())
            if (!initialOldAmount || initialOldAmount === '0' || enrollmentSelect.value) { 
                updateAmount();
            }
        });
    </script>
    @endpush
    
</x-app-layout>