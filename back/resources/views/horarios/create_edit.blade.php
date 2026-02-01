<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nueva Inscripción') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Alertas de Error --}}
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

                            {{-- Alumno --}}
                            <div class="col-span-1">
                                <label class="block text-sm font-medium text-gray-700">Alumno *</label>
                                <select name="alumno_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">-- Seleccione Alumno --</option>
                                    @foreach ($alumnos as $alumno)
                                        <option value="{{ $alumno->id }}" {{ old('alumno_id', $alumnoId ?? '') == $alumno->id ? 'selected' : '' }}>
                                            {{ $alumno->user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Categoría --}}
                            <div class="col-span-1">
                                <label class="block text-sm font-medium text-gray-700">Categoría/Curso *</label>
                                <select name="categoria_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">-- Seleccione Categoría --</option>
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                            {{ $categoria->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Horario (REQUERIDO) --}}
                            <div class="col-span-1">
                                <label class="block text-sm font-medium text-gray-700">Horario *</label>
                                <select name="horario_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">-- Seleccione Horario --</option>
                                    @foreach ($horarios as $horario)
                                        <option value="{{ $horario->id }}" {{ old('horario_id') == $horario->id ? 'selected' : '' }}>
                                            {{ $horario->dia_semana }} ({{ $horario->hora_inicio }} - {{ $horario->hora_fin }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Periodo --}}
                            <div class="col-span-1">
                                <label class="block text-sm font-medium text-gray-700">Periodo *</label>
                                <select name="plantilla_periodo_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">-- Seleccione Periodo --</option>
                                    @foreach ($periodos as $periodo)
                                        <option value="{{ $periodo->id }}" {{ old('plantilla_periodo_id') == $periodo->id ? 'selected' : '' }}>
                                            {{ $periodo->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Fecha de Inicio --}}
                            <div class="col-span-1">
                                <label class="block text-sm font-medium text-gray-700">Fecha de Inicio *</label>
                                <input type="date" name="fecha_inicio" id="fecha_inicio" 
                                    value="{{ old('fecha_inicio', now()->format('Y-m-d')) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            {{-- Fecha de Fin (REQUERIDO) --}}
                            <div class="col-span-1">
                                <label class="block text-sm font-medium text-gray-700">Fecha de Fin *</label>
                                <input type="date" name="fecha_fin" id="fecha_fin" 
                                    value="{{ old('fecha_fin') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            <div class="col-span-2 border-t border-gray-100 pt-4 mt-2">
                                <h3 class="text-sm font-semibold text-gray-600 uppercase">Información de Pago</h3>
                            </div>

                            {{-- Concepto de Pago --}}
                            <div class="col-span-1">
                                <label class="block text-sm font-medium text-gray-700">Plan de Pago *</label>
                                <select name="concepto_pago_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">-- Seleccione Plan --</option>
                                    @foreach ($conceptosPago as $concepto)
                                        <option value="{{ $concepto->id }}" {{ old('concepto_pago_id') == $concepto->id ? 'selected' : '' }}>
                                            {{ $concepto->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Monto Total --}}
                            <div class="col-span-1">
                                <label class="block text-sm font-medium text-gray-700">Monto Total (S/.) *</label>
                                <input type="number" step="0.01" name="monto_total_inscripcion" value="{{ old('monto_total_inscripcion') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            {{-- Estado --}}
                            <div class="col-span-1">
                                <label class="block text-sm font-medium text-gray-700">Estado *</label>
                                <select name="estado" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="vigente" {{ old('estado', 'vigente') == 'vigente' ? 'selected' : '' }}>Vigente</option>
                                    <option value="pendiente" {{ old('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                </select>
                            </div>

                            {{-- Campo Oculto para Fecha de Inscripción --}}
                            <input type="hidden" name="fecha_inscripcion" value="{{ now()->format('Y-m-d') }}">

                        </div>

                        <div class="flex justify-end mt-8 space-x-3 border-t pt-5">
                            <a href="{{ route('inscripciones.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 shadow-sm">
                                Cancelar
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                                Crear Inscripción
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Script de Automatización de Fechas --}}
    <script>
        document.getElementById('fecha_inicio').addEventListener('change', function() {
            let fechaInicio = new Date(this.value);
            if (!isNaN(fechaInicio.getTime())) {
                // Sumar 30 días automáticamente
                fechaInicio.setDate(fechaInicio.getDate() + 30);
                let fechaFin = fechaInicio.toISOString().split('T')[0];
                document.getElementById('fecha_fin').value = fechaFin;
            }
        });
    </script>
</x-app-layout>