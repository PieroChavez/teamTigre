<x-app-layout>
    @section('header', 'Registrar Cuota Extra para: ' . $alumno->user->name)

    <div class="container mx-auto p-6">
        <div class="max-w-3xl mx-auto bg-white shadow-xl rounded-xl p-8 border border-gray-200">
            
            <h1 class="text-2xl font-extrabold text-gray-800 mb-6 border-b pb-3 flex items-center gap-2">
                <i class="fa-solid fa-file-invoice-dollar text-blue-600"></i> Asignar Cuota Manual
            </h1>

            {{-- Alertas de Sesión --}}
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <form action="{{ route('cuotas.storeForAlumno', $alumno->id) }}" method="POST" class="space-y-6">
                @csrf
                
                {{-- 1. Selección de Inscripción (Obligatorio) --}}
                <div>
                    <label for="inscripcion_id" class="block text-sm font-medium text-gray-700 required">
                        <i class="fa-solid fa-graduation-cap mr-1"></i> Asignar a Inscripción Vigente
                    </label>
                    <select id="inscripcion_id" name="inscripcion_id" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('inscripcion_id') border-red-500 @enderror">
                        <option value="">--- Seleccione una Inscripción Activa ---</option>
                        {{-- $inscripcionesConCuenta viene del método createForAlumno --}}
                        @foreach($inscripcionesConCuenta as $inscripcion)
                            <option value="{{ $inscripcion->id }}" {{ old('inscripcion_id') == $inscripcion->id ? 'selected' : '' }}>
                                {{-- Mostramos la cuenta asociada para confirmar --}}
                                [Cuenta #{{ $inscripcion->cuentasInscripcion->first()->id ?? 'N/A' }}] {{ $inscripcion->categoria->nombre }} ({{ $inscripcion->periodo->nombre }})
                            </option>
                        @endforeach
                    </select>
                    @error('inscripcion_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- 2. Selección de Concepto (Obligatorio) --}}
                <div>
                    <label for="concepto_pago_id" class="block text-sm font-medium text-gray-700 required">
                        <i class="fa-solid fa-list-check mr-1"></i> Concepto de la Cuota
                    </label>
                    <select id="concepto_pago_id" name="concepto_pago_id" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('concepto_pago_id') border-red-500 @enderror">
                        <option value="">--- Seleccione un Concepto ---</option>
                        {{-- $conceptosPago viene del método createForAlumno --}}
                        @foreach($conceptosPago as $concepto)
                            <option value="{{ $concepto->id }}" {{ old('concepto_pago_id') == $concepto->id ? 'selected' : '' }}>
                                {{ $concepto->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('concepto_pago_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>


                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- 3. Monto (Obligatorio) --}}
                    <div>
                        <label for="monto" class="block text-sm font-medium text-gray-700 required">
                            <i class="fa-solid fa-sack-dollar mr-1"></i> Monto Total de la Cuota ($)
                        </label>
                        <input type="number" id="monto" name="monto" step="0.01" min="0.01" required value="{{ old('monto') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-lg @error('monto') border-red-500 @enderror"
                               placeholder="Ej: 75.00">
                        @error('monto')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- 4. Fecha de Vencimiento (Opcional, con valor por defecto) --}}
                    <div>
                        <label for="fecha_vencimiento" class="block text-sm font-medium text-gray-700">
                            <i class="fa-solid fa-calendar-alt mr-1"></i> Fecha de Vencimiento (Recomendada)
                        </label>
                        <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" value="{{ old('fecha_vencimiento', now()->addDays(7)->toDateString()) }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('fecha_vencimiento') border-red-500 @enderror">
                        @error('fecha_vencimiento')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Botón de Enviar --}}
                <div class="pt-4">
                    <button type="submit"
                            class="w-full inline-flex justify-center items-center px-4 py-3 bg-blue-600 text-white rounded-md shadow-md hover:bg-blue-700 transition font-semibold">
                        <i class="fa-solid fa-plus-circle mr-3 text-lg"></i> Registrar Cuota Extra
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>