<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Mi Historial de Inscripciones') }}
                </h2>
                <p class="text-sm text-gray-500">Consulta el registro de todos tus ciclos pasados y actuales</p>
            </div>
            <a href="{{ route('student.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if ($enrollments->isEmpty())
                <div class="bg-white rounded-3xl p-12 text-center shadow-sm border border-gray-100">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-yellow-50 text-yellow-500 rounded-full mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Sin historial registrado</h3>
                    <p class="text-gray-500">Aún no tienes inscripciones en nuestro sistema.</p>
                </div>
            @else
                <div class="bg-white shadow-sm border border-gray-100 overflow-hidden sm:rounded-2xl">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-gray-50/50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Disciplina y Plan</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Periodo</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Estado</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Tiempo Restante</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach ($enrollments as $enrollment)
                                    @php
                                        $endDate = $enrollment->end_date ? \Carbon\Carbon::parse($enrollment->end_date) : null;
                                        $endDateISO = $endDate ? $endDate->toIso8601String() : null;
                                        
                                        // Estilos dinámicos de estado
                                        $statusStyles = [
                                            'active' => 'bg-green-100 text-green-700',
                                            'suspended' => 'bg-amber-100 text-amber-700',
                                            'finished' => 'bg-gray-100 text-gray-600',
                                        ];
                                        $currentStyle = $statusStyles[$enrollment->status] ?? 'bg-blue-100 text-blue-700';
                                    @endphp

                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-5">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 bg-indigo-50 rounded-lg flex items-center justify-center text-indigo-600 font-bold text-lg">
                                                    {{ substr($enrollment->category->name, 0, 1) }}
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-bold text-gray-900">{{ $enrollment->category->name }}</div>
                                                    <div class="text-xs text-gray-500">{{ $enrollment->plan->name ?? 'Plan Base' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <div class="text-sm text-gray-700">
                                                <span class="font-medium">{{ \Carbon\Carbon::parse($enrollment->start_date)->format('d M, Y') }}</span>
                                                <span class="text-gray-300 mx-1">→</span>
                                                <span class="font-medium">{{ $endDate ? $endDate->format('d M, Y') : 'Indefinido' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full uppercase tracking-tighter {{ $currentStyle }}">
                                                {{ ucfirst($enrollment->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            @if ($enrollment->status == 'active' && $endDateISO)
                                                <div class="flex items-center space-x-2">
                                                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                                    <span id="countdown-{{ $enrollment->id }}" 
                                                          class="text-sm font-mono font-bold text-gray-600"
                                                          data-end-date="{{ $endDateISO }}">
                                                        Calculando...
                                                    </span>
                                                </div>
                                            @else
                                                <span class="text-sm text-gray-400 font-medium">No disponible</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const countdownElements = document.querySelectorAll('[id^="countdown-"]');
            countdownElements.forEach(element => {
                const endDateString = element.getAttribute('data-end-date');
                if (endDateString && endDateString !== 'null') { 
                    const endTime = new Date(endDateString).getTime();
                    const updateCountdown = () => {
                        const now = new Date().getTime();
                        const distance = endTime - now;
                        if (distance < 0) {
                            element.innerHTML = "FINALIZADO";
                            element.classList.add('text-red-500');
                        } else {
                            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                            element.innerHTML = `${days}d ${String(hours).padStart(2,'0')}h ${String(minutes).padStart(2,'0')}m ${String(seconds).padStart(2,'0')}s`;
                        }
                    };
                    updateCountdown();
                    setInterval(updateCountdown, 1000);
                }
            });
        });
    </script>
</x-app-layout>