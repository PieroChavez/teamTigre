<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Pago') }} #{{ $payment->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">

                    <div class="flex justify-between items-center mb-6 border-b pb-3">
                        <h3 class="text-2xl font-bold text-gray-800">
                            Modificar Transacción
                        </h3>
                        <a href="{{ route('admin.payments.show', $payment) }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">
                            ← Volver al Detalle
                        </a>
                    </div>
                    
                    {{-- Formulario de Edición --}}
                    <form method="POST" action="{{ route('admin.payments.update', $payment) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            {{-- Campo de Inscripción (Enrollment) --}}
                            <div>
                                <label for="enrollment_id" class="block text-sm font-medium text-gray-700">Inscripción (Alumno - Clase)</label>
                                <select name="enrollment_id" id="enrollment_id" required 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('enrollment_id') border-red-500 @enderror">
                                    <option value="">Seleccione Inscripción</option>
                                    @foreach($enrollments as $enrollment)
                                        <option value="{{ $enrollment->id }}" 
                                            @selected(old('enrollment_id', $payment->enrollment_id) == $enrollment->id)>
                                            {{ $enrollment->studentProfile->user->name ?? 'Alumno N/A' }} - {{ $enrollment->category->name ?? 'Clase N/A' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('enrollment_id') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Campo de Monto --}}
                            <div>
                                <label for="amount" class="block text-sm font-medium text-gray-700">Monto (S/)</label>
                                <input type="number" step="0.01" name="amount" id="amount" required 
                                    value="{{ old('amount', $payment->amount) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('amount') border-red-500 @enderror">
                                @error('amount') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Campo de Método --}}
                            <div>
                                <label for="method" class="block text-sm font-medium text-gray-700">Método de Pago</label>
                                <select name="method" id="method" required 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('method') border-red-500 @enderror">
                                    @php $currentMethod = old('method', $payment->method); @endphp
                                    <option value="cash" @selected($currentMethod == 'cash')>Efectivo</option>
                                    <option value="transfer" @selected($currentMethod == 'transfer')>Transferencia</option>
                                    <option value="card" @selected($currentMethod == 'card')>Tarjeta</option>
                                    <option value="online" @selected($currentMethod == 'online')>Online</option>
                                </select>
                                @error('method') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                            </div>
                            
                            {{-- Campo de Fecha Pagada --}}
                            <div>
                                <label for="paid_at" class="block text-sm font-medium text-gray-700">Fecha Pagada</label>
                                <input type="date" name="paid_at" id="paid_at" 
                                    value="{{ old('paid_at', $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('Y-m-d') : null) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('paid_at') border-red-500 @enderror">
                                <p class="text-xs text-gray-500 mt-1">Dejar vacío si el pago aún está Pendiente.</p>
                                @error('paid_at') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Campo de Estado (CRUCIAL) --}}
                            <div class="md:col-span-2">
                                <label for="status" class="block text-sm font-medium text-gray-700">Estado del Pago</label>
                                <select name="status" id="status" required 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('status') border-red-500 @enderror">
                                    @php $currentStatus = old('status', $payment->status); @endphp
                                    <option value="pending" @selected($currentStatus == 'pending')>Pendiente</option>
                                    <option value="paid" @selected($currentStatus == 'paid')>Pagado</option>
                                    <option value="expired" @selected($currentStatus == 'expired')>Vencido</option>
                                    <option value="cancelled" @selected($currentStatus == 'cancelled')>Anulado (Admin)</option>
                                </select>
                                @error('status') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Campo de Detalles (Opcional) --}}
                            <div class="md:col-span-2">
                                <label for="details" class="block text-sm font-medium text-gray-700">Detalles/Notas (Opcional)</label>
                                <textarea name="details" id="details" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('details') border-red-500 @enderror">{{ old('details', $payment->details ?? '') }}</textarea>
                                @error('details') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                            </div>

                        </div>

                        {{-- Botón de Guardar --}}
                        <div class="mt-8 pt-4 border-t">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Guardar Cambios del Pago
                            </button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>