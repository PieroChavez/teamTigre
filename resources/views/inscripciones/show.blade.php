<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-200">
            Detalles de Inscripción #{{ $inscripcion->id }}
        </h2>
    </x-slot>

    <div class="p-6">
        <div class="max-w-4xl mx-auto bg-gray-800 shadow-xl rounded-lg overflow-hidden">
            
            <div class="flex justify-between items-center p-6 bg-gray-900 border-b border-gray-700">
                <h3 class="text-2xl font-bold text-orange-500">
                    Resumen de la Matrícula
                </h3>
                
                {{-- Botón de Edición --}}
                <a href="{{ route('inscripciones.edit', $inscripcion) }}" 
                   class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition duration-150">
                    <i class="fa-solid fa-pen-to-square mr-2"></i> Editar Inscripción
                </a>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-y-6 gap-x-8 text-gray-300">
                
                {{-- Columna 1: Alumno --}}
                <div class="space-y-4">
                    <h4 class="text-lg font-semibold border-b pb-1 border-gray-700 text-gray-100">Datos del Alumno</h4>
                    
                    <div>
                        <p class="text-sm text-gray-400">Nombre Completo</p>
                        <p class="text-base font-medium text-white">{{ $inscripcion->alumno->nombre }} {{ $inscripcion->alumno->apellido }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-400">DNI</p>
                        <p class="text-base font-medium">{{ $inscripcion->alumno->dni }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-400">Estado del Alumno</p>
                        <p class="text-base font-medium">{{ $inscripcion->alumno->estado }}</p>
                    </div>
                </div>

                {{-- Columna 2: Detalles de la Clase --}}
                <div class="space-y-4">
                    <h4 class="text-lg font-semibold border-b pb-1 border-gray-700 text-gray-100">Clase y Horario</h4>
                    
                    <div>
                        <p class="text-sm text-gray-400">Categoría Inscrita</p>
                        <p class="text-base font-bold text-green-400">{{ $inscripcion->categoria->nombre }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-400">Horario Asignado</p>
                        <p class="text-base font-medium">{{ $inscripcion->horario->dia_semana }}</p>
                        <p class="text-sm text-gray-400">{{ $inscripcion->horario->hora_inicio }} - {{ $inscripcion->horario->hora_fin }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-400">Docente a cargo</p>
                        <p class="text-base font-medium">{{ $inscripcion->horario->docente->user->name ?? 'N/A' }}</p>
                    </div>
                </div>
                
                {{-- Columna 3: Estado y Periodo --}}
                <div class="space-y-4">
                    <h4 class="text-lg font-semibold border-b pb-1 border-gray-700 text-gray-100">Estado y Duración</h4>
                    
                    <div>
                        <p class="text-sm text-gray-400">Periodo</p>
                        <p class="text-base font-medium">{{ $inscripcion->periodo->nombre }}</p>
                        <p class="text-xs text-gray-500">Duración: {{ $inscripcion->periodo->duracion_meses ?? 0 }} meses</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-400">Estado de la Inscripción</p>
                        <span class="px-3 py-1 text-sm rounded-full 
                            @if($inscripcion->estado == 'Activo') bg-green-600 text-white
                            @elseif($inscripcion->estado == 'Completado') bg-blue-600 text-white
                            @else bg-red-600 text-white
                            @endif">
                            {{ $inscripcion->estado }}
                        </span>
                    </div>

                    <div>
                        <p class="text-sm text-gray-400">Fecha de Registro</p>
                        <p class="text-base font-medium">{{ $inscripcion->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-gray-900 border-t border-gray-700">
                <p class="text-gray-400 text-sm">
                    El historial de pagos asociado a esta inscripción se mostraría en una sección separada.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>