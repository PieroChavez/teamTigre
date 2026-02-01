<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nueva Inscripción') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Bloque de Errores de Validación --}}
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
                    <p class="font-bold">Por favor corrige los siguientes errores:</p>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('inscripciones.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

                            {{-- CAMPO: Alumno --}}
                            <div class="col-span-1">
                                <label for="alumno_id" class="block text-sm font-medium text-gray-700">
                                    Alumno <span class="text-red-500">*</span>
                                </label>
                                <select name="alumno_id" id="alumno_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">-- Seleccione Alumno --</option>
                                    @foreach ($alumnos as $alumno)
                                        <option value="{{ $alumno->id }}" {{ old('alumno_id', $alumnoId ?? '') == $alumno->id ? 'selected' : '' }}>
                                            {{ $alumno->user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- CAMPO: Categoría/Curso --}}
                            <div class="col-span-1">
                                <label for="categoria_id" class="block text-sm font-medium text-gray-700">
                                    Categoría/Curso <span class="text-red-500">*</span>
                                </label>
                                <select name="categoria_id" id="categoria_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">-- Seleccione Categoría --</option>
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                            {{ $categoria->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- CAMPO: Horario (NUEVO - REQUERIDO) --}}
                            <div class="col-span-1">
                                <label for="horario_id" class="block text-sm font-medium text-gray-700">
                                    Horario <span class="text-red-500">*</span>
                                </label>
                                <select name="horario_id" id="horario_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">-- Seleccione Horario --</option>
                                    @foreach ($horarios as $horario)
                                        <option value="{{ $horario->id }}" {{ old('horario_id') == $horario->id ? 'selected' : '' }}>
                                            {{ $horario->nombre }} ({{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- CAMPO: Periodo --}}
                            <div class="col-span-1">
                                <label for="plantilla_periodo_id" class="block text-sm font-medium text-gray-700">
                                    Periodo <span class="text-red-500">*</span>
                                </label>
                                <select name="plantilla_periodo_id" id="plantilla_periodo_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">-- Seleccione Periodo --</option>
                                    @foreach ($periodos as $periodo)
                                        <option value="{{ $periodo->id }}" {{ old('plantilla_periodo_id') == $periodo->id ? 'selected' : '' }}>
                                            {{ $periodo->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- CAMPO: Fecha de Inicio --}}
                            <div class="col-span-1">
                                <label for="fecha_inicio" class="block text-sm font-medium text-gray-700">
                                    Fecha de Inicio <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="fecha_inicio" id="fecha_inicio" 
                                    value="{{ old('fecha_inicio', now()->format('Y-m-d')) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            {{-- CAMPO: Fecha de Fin (NUEVO - REQUERIDO) --}}
                            <div class="col-span-1">
                                <label for="fecha_fin" class="block text-sm font-medium text-gray-700">
                                    Fecha de Fin <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="fecha_fin" id="fecha_fin" 
                                    value="{{ old('fecha_fin') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <div class="col-span-2 border-t border-gray-100 pt-4 mt-2">
                                <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Información de Pago</h3>
                            </div>

                            {{-- CAMPO: Plan de Pago --}}
                            <div class="col-span-1">
                                <label for="concepto_pago_id" class="block text-sm font-medium text-gray-700">
                                    Plan de Pago <span class="text-red-500">*</span>
                                </label>
                                <select name="concepto_pago_id" id="concepto_pago_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">-- Seleccione Plan --</option>
                                    @foreach ($conceptosPago as $concepto)
                                        <option value="{{ $concepto->id }}" {{ old('concepto_pago_id') == $concepto->id ? 'selected' : '' }}>
                                            {{ $concepto->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- CAMPO: Monto Total --}}
                            <div class="col-span-1">
                                <label for="monto_total_inscripcion" class="block text-sm font-medium text-gray-700">
                                    Monto Total (S/.) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" step="0.01" name="monto_total_inscripcion" id="monto_total_inscripcion" 
                                    value="{{ old('monto_total_inscripcion') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    placeholder="0.00">
                            </div>

                            {{-- CAMPO: Estado --}}
                            <div class="col-span-1">
                                <label for="estado" class="block text-sm font-medium text-gray-700">
                                    Estado <span class="text-red-500">*</span>
                                </label>
                                <select name="estado" id="estado" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="vigente" {{ old('estado', 'vigente') == 'vigente' ? 'selected' : '' }}>Vigente</option>
                                    <option value="pendiente" {{ old('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                </select>
                            </div>

                            {{-- Campo oculto para cumplir con el controlador --}}
                            <input type="hidden" name="fecha_inscripcion" value="{{ now()->format('Y-m-d') }}">

                        </div>

                        <div class="flex justify-end mt-8 space-x-3 border-t pt-5">
                            <a href="{{ route('inscripciones.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 shadow-sm">
                                {{ __('Cancelar') }}
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500">
                                {{ __('Crear Inscripción') }}
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>