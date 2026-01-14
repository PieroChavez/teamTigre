<x-app-layout>
    <x-slot name="header">
        {{ __('Editar Inscripción') }}
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('inscripciones.update', $inscripcion) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

                            {{-- Alumno --}}
                            <div class="col-span-1">
                                <label for="alumno_id" class="block text-sm font-medium text-gray-700">
                                    Alumno 
                                </label>
                                <input type="text" value="{{ $inscripcion->alumno->user->name }}" readonly
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 sm:text-sm">
                                <input type="hidden" name="alumno_id" value="{{ $inscripcion->alumno_id }}">
                            </div>

                            {{-- Categoría/Curso --}}
                            <div class="col-span-1">
                                <label for="categoria_id" class="block text-sm font-medium text-gray-700">
                                    Categoría/Curso <span class="text-red-500">*</span>
                                </label>
                                <select name="categoria_id" id="categoria_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('categoria_id') border-red-500 @enderror">
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id }}" {{ old('categoria_id', $inscripcion->categoria_id) == $categoria->id ? 'selected' : '' }}>
                                            {{ $categoria->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('categoria_id')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Periodo --}}
                            <div class="col-span-1">
                                <label for="plantilla_periodo_id" class="block text-sm font-medium text-gray-700">
                                    Periodo <span class="text-red-500">*</span>
                                </label>
                                <select name="plantilla_periodo_id" id="plantilla_periodo_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('plantilla_periodo_id') border-red-500 @enderror">
                                    @foreach ($periodos as $periodo)
                                        <option value="{{ $periodo->id }}" {{ old('plantilla_periodo_id', $inscripcion->plantilla_periodo_id) == $periodo->id ? 'selected' : '' }}>
                                            {{ $periodo->nombre }} ({{ $periodo->fecha_inicio?->format('d/M') ?? 'N/A' }} - {{ $periodo->fecha_fin?->format('d/M') ?? 'N/A' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('plantilla_periodo_id')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            {{-- Fecha de inscripción --}}
                            <div class="col-span-1">
                                <label for="fecha_inscripcion" class="block text-sm font-medium text-gray-700">
                                    Fecha de Inscripción <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="fecha_inscripcion" id="fecha_inscripcion" value="{{ old('fecha_inscripcion', $inscripcion->fecha_inscripcion?->toDateString()) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('fecha_inscripcion') border-red-500 @enderror">
                                @error('fecha_inscripcion')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Estado --}}
                            <div class="col-span-1">
                                <label for="estado" class="block text-sm font-medium text-gray-700">
                                    Estado <span class="text-red-500">*</span>
                                </label>
                                <select name="estado" id="estado" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('estado') border-red-500 @enderror">
                                    <option value="vigente" {{ old('estado', $inscripcion->estado) == 'vigente' ? 'selected' : '' }}>Vigente</option>
                                    <option value="pendiente" {{ old('estado', $inscripcion->estado) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="finalizado" {{ old('estado', $inscripcion->estado) == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                                    <option value="retirado" {{ old('estado', $inscripcion->estado) == 'retirado' ? 'selected' : '' }}>Retirado</option>
                                </select>
                                @error('estado')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Botones --}}
                        <div class="flex justify-end mt-6 space-x-3">
                            <a href="{{ route('inscripciones.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                {{ __('Cancelar') }}
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                                <i class="fa-solid fa-arrows-rotate mr-2"></i> {{ __('Actualizar Inscripción') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
