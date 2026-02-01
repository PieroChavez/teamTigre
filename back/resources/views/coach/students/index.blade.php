<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Alumnos Inscritos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Mensaje Informativo para el Coach --}}
            <div class="bg-indigo-100 border-l-4 border-indigo-500 text-indigo-700 p-4 mb-6 rounded-lg shadow-sm" role="alert">
                <p class="font-bold">Vista de Coach</p>
                <p class="text-sm">Solo ves a los alumnos que están actualmente inscritos en las categorías que tienes asignadas.</p>
            </div>

            {{-- TABLA DE ALUMNOS FILTRADOS --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-1/4">
                                Nombre / Contacto
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-1/4">
                                Categoría / Plan
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Fin de Inscripción
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-1/5">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($students as $student)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            {{-- Columna 1: Nombre y Contacto --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $student->name }}</div>
                                <div class="text-xs text-gray-500">{{ $student->email }}</div>
                                @if($student->studentProfile)
                                    <div class="text-xs text-gray-500">Tel: {{ $student->studentProfile->phone ?? 'N/A' }}</div>
                                @endif
                            </td>

                            {{-- Columna 2: Categoría y Plan Activo --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    // El controlador solo trae inscripciones activas y relevantes. 
                                    // Si hay múltiples, tomamos la primera para mostrar el resumen.
                                    $enrollment = $student->studentProfile->enrollments->first(); 
                                @endphp

                                @if($enrollment)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-lg bg-indigo-100 text-indigo-800">
                                        {{ $enrollment->category->name ?? 'Categoría Desconocida' }}
                                    </span>
                                    <div class="text-xs text-gray-500 mt-1">Plan: {{ $enrollment->plan->name ?? 'N/A' }}</div>
                                @else
                                    <span class="text-sm text-gray-400">Sin inscripción activa visible</span>
                                @endif
                            </td>
                            
                            {{-- Columna 3: Fin de Inscripción (Días Restantes) --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($enrollment)
                                    @php
                                        $endDate = \Carbon\Carbon::parse($enrollment->end_date);
                                        $remainingDays = now()->diffInDays($endDate, false); 
                                        $color = $remainingDays <= 7 ? 'text-red-600 font-bold' : 'text-green-600';
                                    @endphp
                                    <div class="text-sm text-gray-700">Finaliza: {{ $endDate->format('d/m/Y') }}</div>
                                    <div class="text-xs {{ $color }} mt-0.5">
                                        Quedan: {{ $remainingDays < 0 ? '¡EXPIRADO!' : $remainingDays . ' días' }}
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400">N/A</span>
                                @endif
                            </td>

                            {{-- Columna 4: Acciones --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('coach.students.show', $student) }}" class="text-indigo-600 hover:text-indigo-900">Ver Perfil</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                No tienes alumnos activos inscritos en tus categorías asignadas.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>