<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Mi Historial de Asistencias') }}
                </h2>
                <p class="text-sm text-gray-500">Registro detallado de tus clases tomadas</p>
            </div>
            <a href="{{ route('student.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Volver al Portal
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @forelse ($enrollments as $enrollment)
                @php
                    $attendances = $historyByEnrollment->get($enrollment->id) ?? collect();
                    $totalPresent = $attendances->where('status', 'present')->count();
                    $totalAbsent = $attendances->where('status', 'absent')->count();
                    
                    $statusMap = [
                        'active' => ['label' => 'Activo', 'style' => 'bg-green-100 text-green-700'],
                        'finished' => ['label' => 'Finalizado', 'style' => 'bg-gray-100 text-gray-600'],
                        'suspended' => ['label' => 'Suspendido', 'style' => 'bg-red-100 text-red-700'],
                    ];
                    $currentStatus = $statusMap[$enrollment->status] ?? ['label' => $enrollment->status, 'style' => 'bg-blue-100 text-blue-700'];
                @endphp

                <div class="bg-white overflow-hidden shadow-sm border border-gray-100 sm:rounded-3xl transition-all hover:shadow-md">
                    <div class="p-6 border-b border-gray-50 bg-gray-50/30">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div class="flex items-center space-x-4">
                                <div class="p-3 bg-indigo-600 rounded-2xl text-white shadow-lg shadow-indigo-100">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900">{{ $enrollment->category->name }}</h3>
                                    <p class="text-xs font-medium uppercase tracking-wider text-gray-400">
                                        Ciclo: {{ \Carbon\Carbon::parse($enrollment->start_date)->format('d/m/Y') }} 
                                        {{ $enrollment->end_date ? ' al ' . \Carbon\Carbon::parse($enrollment->end_date)->format('d/m/Y') : '' }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2">
                                <span class="px-3 py-1 bg-green-50 text-green-700 rounded-lg text-xs font-bold border border-green-100">
                                    {{ $totalPresent }} Asistencias
                                </span>
                                <span class="px-3 py-1 bg-red-50 text-red-700 rounded-lg text-xs font-bold border border-red-100">
                                    {{ $totalAbsent }} Faltas
                                </span>
                                <span class="px-3 py-1 {{ $currentStatus['style'] }} rounded-lg text-xs font-bold uppercase tracking-tighter">
                                    {{ $currentStatus['label'] }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="p-0 sm:p-6">
                        @if ($attendances->isEmpty())
                            <div class="p-8 text-center">
                                <p class="text-gray-400 font-medium">No hay registros de asistencia en este periodo.</p>
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-100">
                                    <thead>
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Fecha de Clase</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Día</th>
                                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-400 uppercase tracking-widest">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50">
                                        @foreach ($attendances as $attendance)
                                            <tr class="hover:bg-gray-50/50 transition-colors">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-700">
                                                    {{ \Carbon\Carbon::parse($attendance->date)->format('d \d\e M, Y') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 capitalize">
                                                    {{ \Carbon\Carbon::parse($attendance->date)->locale('es')->translatedFormat('l') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    @if($attendance->status === 'present')
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                                            Presente
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                                            Falta
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white p-12 rounded-3xl border-2 border-dashed border-gray-200 text-center">
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Sin historial</h3>
                    <p class="mt-1 text-sm text-gray-500">No tienes registros de asistencia para mostrar.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>