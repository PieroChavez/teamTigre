<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">
            Historial de Asistencia - {{ $category->name }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="p-6">
                <a href="{{ route('coach.attendance.index', $category) }}" class="text-blue-600 hover:text-blue-800 font-medium mb-4 inline-block">
                    ← Volver a Tomar Asistencia
                </a>

                <h3 class="text-xl font-bold mb-4">Últimos 7 Días de Asistencia</h3>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-100 z-10">
                                    Alumno
                                </th>
                                {{-- Encabezados de Columna (Fechas) --}}
                                @foreach ($dateRange as $date)
                                    <th class="p-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ \Carbon\Carbon::parse($date)->format('D d/M') }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($enrollments as $enrollment)
                                <tr>
                                    {{-- Nombre del Alumno --}}
                                    <td class="p-3 whitespace-nowrap text-sm font-medium text-gray-900 sticky left-0 bg-white z-10 border-r">
                                        {{ $enrollment->studentProfile->user->name }}
                                    </td>
                                    
                                    {{-- Celdas de Asistencia por Día --}}
                                    @foreach ($dateRange as $date)
                                        @php
                                            $attendanceForDate = $recentAttendances->get($date) ?? collect();
                                            $record = $attendanceForDate->firstWhere('enrollment_id', $enrollment->id);
                                            
                                            $status = optional($record)->status;
                                            $bgColor = 'bg-white'; // Por defecto
                                            $icon = '—'; // No registrado
                                            
                                            if ($status === 'present') {
                                                $bgColor = 'bg-green-100';
                                                $icon = '✔️';
                                            } elseif ($status === 'absent') {
                                                $bgColor = 'bg-red-100';
                                                $icon = '❌';
                                            }
                                        @endphp

                                        <td class="p-3 text-center text-base {{ $bgColor }}">
                                            {{ $icon }}
                                        </td>
                                    @endforeach
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ count($dateRange) + 1 }}" class="p-4 text-center text-gray-500">
                                        No hay alumnos activos en esta categoría.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <p class="mt-4 text-sm text-gray-600">Mostrando datos de asistencia de los últimos 7 días. Esta matriz puede ser extendida para mostrar más días.</p>
    </div>
</x-app-layout>