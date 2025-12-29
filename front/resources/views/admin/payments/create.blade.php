<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Registrar Nuevo Pago') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">

                    <h3 class="text-2xl font-bold text-indigo-600 mb-6 border-b pb-2">
                        Pago para: {{ $studentProfile->user->name }}
                    </h3>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.payments.store') }}">
                        @csrf
                        
                        {{-- Campo oculto para llevar el ID del Perfil del Estudiante --}}
                        <input type="hidden" name="student_profile_id" value="{{ $studentProfile->id }}">

                        {{-- 1. Inscripción (Clase) --}}
                        <div class="mb-4">
                            <label for="enrollment_id" class="block font-medium text-sm text-gray-700">Clase / Inscripción Activa</label>
                            <select id="enrollment_id" name="enrollment_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">-- Seleccione una Inscripción Activa --</option>
                                @forelse ($enrollments as $enrollment)
                                    {{-- Mostrar la clase y el plan --}}
                                    <option 
                                        value="{{ $enrollment->id }}"
                                        data-amount="{{ $enrollment->plan->price ?? 0 }}"
                                        {{ old('enrollment_id') == $enrollment->id ? 'selected' : '' }}
                                    >
                                        {{ $enrollment->category->name }} (Plan: {{ $enrollment->plan->name ?? 'N/A' }}) - Cuota: ${{ number_format($enrollment->plan->price ?? 0, 2) }}
                                    </option>
                                @empty
                                    <option value="" disabled>No hay inscripciones activas para este alumno.</option>
                                @endforelse
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Solo se muestran inscripciones con estado "Active".</p>
                        </div>

                        {{-- 2. Monto Pagado --}}
                        <div class="mb-4">
                            <label for="amount" class="block font-medium text-sm text-gray-700">Monto Pagado (S/)</label>
                            <input type="number" id="amount" name="amount" step="0.01" min="0.01" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required value="{{ old('amount') }}">
                        </div>

                        {{-- 3. Método de Pago --}}
                        <div class="mb-4">
                            <label for="method" class="block font-medium text-sm text-gray-700">Método</label>
                            <select id="method" name="method" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">-- Seleccione el Método --</option>
                                <option value="cash" {{ old('method') == 'cash' ? 'selected' : '' }}>Efectivo</option>
                                <option value="yape" {{ old('method') == 'yape' ? 'selected' : '' }}>Yape</option>
                                <option value="transfer" {{ old('method') == 'transfer' ? 'selected' : '' }}>Transferencia</option>
                            </select>
                        </div>
                        
                        {{-- 4. Fecha de Pago --}}
                        <div class="mb-4">
                            <label for="paid_at" class="block font-medium text-sm text-gray-700">Fecha en que se realizó el pago</label>
                            <input type="date" id="paid_at" name="paid_at" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required value="{{ old('paid_at', date('Y-m-d')) }}">
                        </div>

                        {{-- 5. Notas --}}
                        <div class="mb-6">
                            <label for="notes" class="block font-medium text-sm text-gray-700">Notas Adicionales (Opcional)</label>
                            <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('notes') }}</textarea>
                        </div>

                        <div class="flex justify-end">
                            <a href="{{ route('admin.payments.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-2">
                                Cancelar
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                Registrar Pago
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    // Pequeño script para rellenar el monto tentativo al seleccionar la inscripción
    document.getElementById('enrollment_id').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var amountInput = document.getElementById('amount');
        var defaultAmount = selectedOption.getAttribute('data-amount');

        if (defaultAmount) {
            amountInput.value = defaultAmount;
        } else if (amountInput.value === '') {
             // Si no hay monto predefinido y el campo está vacío, lo dejamos vacío
             amountInput.value = ''; 
        }
    });
</script>