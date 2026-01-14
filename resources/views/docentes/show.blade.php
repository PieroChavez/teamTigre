<x-app-layout>
    @section('header', 'Detalle de Docente')

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg overflow-hidden">

                {{-- Encabezado y Título --}}
                <div class="p-6 bg-indigo-50 border-b border-indigo-200">
                    <div class="flex justify-between items-center">
                        <h2 class="text-3xl font-bold text-indigo-700">
                            <i class="fa-solid fa-user-tie mr-3"></i> Detalle de {{ $docente->user->name }}
                        </h2>
                        <a href="{{ route('docentes.edit', $docente) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition ease-in-out duration-150 shadow-md">
                            <i class="fa-solid fa-pen-to-square mr-2"></i> Editar Perfil
                        </a>
                    </div>
                </div>

                {{-- Mensajes de Sesión --}}
                @if (session('status'))
                    <div class="p-4 bg-green-50 text-green-700 border-l-4 border-green-500">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- Contenido Principal --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 p-6 lg:p-8">

                    {{-- === COLUMNA 1: Datos Generales y Experiencia === --}}
                    <div class="lg:col-span-1 bg-gray-50 p-6 rounded-lg shadow-inner border border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-800 border-b pb-2 mb-4 flex items-center">
                            <i class="fa-solid fa-id-card mr-2"></i> Información Personal
                        </h3>
                        
                        <dl class="space-y-3 text-sm">
                            <div>
                                <dt class="font-medium text-gray-500">Email (Usuario)</dt>
                                <dd class="text-gray-900">{{ $docente->user->email }}</dd>
                            </div>
                            <hr class="border-gray-200">
                            <div>
                                <dt class="font-medium text-gray-500">DNI / Identificación</dt>
                                <dd class="text-gray-900">{{ $docente->dni }}</dd>
                            </div>
                            <div>
                                <dt class="font-medium text-gray-500">Teléfono</dt>
                                <dd class="text-gray-900">{{ $docente->telefono ?? 'No registrado' }}</dd>
                            </div>
                            <div>
                                <dt class="font-medium text-gray-500">Especialidad</dt>
                                <dd class="text-lg font-bold text-indigo-600">{{ $docente->especialidad }}</dd>
                            </div>
                            <hr class="border-gray-200">
                            <div>
                                <dt class="font-medium text-gray-500">Estado Actual</dt>
                                <dd>
                                    @if ($docente->estado === 'activo')
                                        <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                            ACTIVO
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full bg-red-100 text-red-800">
                                            INACTIVO
                                        </span>
                                    @endif
                                </dd>
                            </div>
                        </dl>

                        {{-- === BLOQUE DE EXPERIENCIA AÑADIDO === --}}
                        <div class="mt-6 pt-4 border-t border-gray-200">
                            <h4 class="font-bold text-gray-700 flex items-center mb-2">
                                <i class="fa-solid fa-chalkboard-teacher mr-2 text-indigo-600"></i> Experiencia y Certificaciones
                            </h4>
                            @if ($docente->experiencia)
                                {{-- El campo de texto largo se muestra en un bloque preformateado para respetar saltos de línea --}}
                                <div class="bg-white p-3 rounded-md border border-gray-100 text-sm text-gray-800 whitespace-pre-line shadow-sm">
                                    {{ $docente->experiencia }}
                                </div>
                            @else
                                <p class="text-sm italic text-gray-500">
                                    No se ha registrado una descripción de experiencia profesional para este docente.
                                </p>
                            @endif
                        </div>
                        {{-- === FIN BLOQUE EXPERIENCIA === --}}

                    </div>

                   {{-- === COLUMNA 2/3: Horarios Asignados (Clases) (CÓDIGO MEJORADO) === --}}
<div class="lg:col-span-2 bg-white p-6 rounded-xl border border-gray-200 shadow-xl">
    <div class="flex justify-between items-center border-b border-indigo-200 pb-3 mb-4">
        <h3 class="text-2xl font-bold text-indigo-700 flex items-center">
            <i class="fa-solid fa-calendar-day mr-3 text-3xl"></i>
            Horarios de Clase Asignados
        </h3>
        {{-- BOTÓN DE GESTIÓN DE HORARIOS --}}
        <a href="{{ route('horarios.create', ['docente_id' => $docente->id]) }}" 
           class="text-sm px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition duration-200 shadow-md">
            <i class="fa-solid fa-plus-circle mr-1"></i> Asignar Nuevo
        </a>
    </div>
    
    @if ($docente->horarios->isNotEmpty())
        <div class="overflow-x-auto rounded-lg border border-gray-100">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-indigo-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-extrabold text-indigo-700 uppercase tracking-wider">
                            <i class="fa-solid fa-calendar-days"></i> Día
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-extrabold text-indigo-700 uppercase tracking-wider">
                            <i class="fa-solid fa-clock"></i> Horario
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-extrabold text-indigo-700 uppercase tracking-wider">
                            <i class="fa-solid fa-dumbbell"></i> Clase/Materia
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-extrabold text-indigo-700 uppercase tracking-wider">
                            Estado
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-extrabold text-indigo-700 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach ($docente->horarios as $horario)
                        <tr class="hover:bg-indigo-50/20 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                {{ ucfirst($horario->dia_semana) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{-- Formateo a HH:MM, usando los campos hora_inicio y hora_fin de tu DB --}}
                                {{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }} - 
                                {{ \Carbon\Carbon::parse($horario->hora_fin)->format('H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{-- Usamos categoría_id para buscar el nombre si no hay relación Materia --}}
                                <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-bold rounded-full bg-indigo-100 text-indigo-800">
                                    {{ $horario->categoria->nombre ?? 'ID: ' . $horario->categoria_id }} 
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                @php
                                    $is_activo = ($horario->estado ?? 'activo') === 'activo';
                                @endphp
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full 
                                    {{ $is_activo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $is_activo ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                {{-- Enlace para editar el horario --}}
                                <a href="{{ route('horarios.edit', $horario->id) }}" class="text-blue-600 hover:text-blue-800 p-2 rounded-full hover:bg-blue-50 transition" title="Editar Horario">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                
                                {{-- Formulario para eliminar (usa la ruta destroy) --}}
                                <form action="{{ route('horarios.destroy', $horario->id) }}" method="POST" class="inline ml-2" onsubmit="return confirm('¿Confirmas eliminar este horario?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 p-2 rounded-full hover:bg-red-50 transition" title="Eliminar Horario">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="p-6 text-center text-gray-600 bg-yellow-50 rounded-lg border border-yellow-300 shadow-inner">
            <i class="fa-solid fa-info-circle mr-2 text-yellow-600"></i>
            Este docente no tiene ningún horario de clase asignado actualmente.
        </div>
    @endif
</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>