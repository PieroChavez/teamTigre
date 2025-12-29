<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Panel del Alumno') }}
            </h2>
            <span class="text-sm bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full font-medium">
                ID: {{ $profile->code ?? 'N/A' }}
            </span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- BIENVENIDA Y RESUMEN RÁPIDO --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center space-x-4">

                    {{-- FOTO --}}
                    <div class="w-12 h-12 rounded-full overflow-hidden flex items-center justify-center 
                        @if($profile && $profile->photo) border-2 border-indigo-200 @else bg-indigo-50 text-indigo-600 @endif">
                        @if($profile && $profile->photo)
                            <img src="{{ asset('storage/' . $profile->photo) }}" 
                                 alt="{{ $alumno->name }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        @endif
                    </div>

                    <div>
                        <h3 class="text-xl font-bold text-gray-900">¡Hola, {{ explode(' ', $alumno->name)[0] }}!</h3>
                        <p class="text-gray-500 text-sm">Qué bueno verte de nuevo. Aquí tienes el resumen de tu cuenta.</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-500">Mi Contacto</p>
                        <p class="font-semibold text-gray-800">{{ $profile->phone ?? 'Sin celular' }}</p>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="p-2 bg-gray-50 hover:bg-indigo-50 text-gray-400 hover:text-indigo-600 rounded-xl transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- SECCIÓN CENTRAL: DATOS Y ALERTAS --}}
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Información Personal</h4>
                        <div class="space-y-4">
                            <div>
                                <label class="text-xs text-gray-400 block">DNI/ID</label>
                                <span class="font-medium text-gray-800">{{ $profile->dni ?? 'N/A' }}</span>
                            </div>
                            <div>
                                <label class="text-xs text-gray-400 block">Email</label>
                                <span class="font-medium text-gray-800 break-all">{{ $alumno->email }}</span>
                            </div>
                            <div>
                                <label class="text-xs text-gray-400 block">Cumpleaños</label>
                                <span class="font-medium text-gray-800">{{ $profile->birth_date ? \Carbon\Carbon::parse($profile->birth_date)->format('d M, Y') : 'N/A' }}</span>
                            </div>
                        </div>

                        @if(!$profile)
                            <div class="mt-6 p-4 bg-red-50 rounded-xl border border-red-100">
                                <p class="text-xs text-red-600 font-medium">Perfil incompleto. Por favor contacta a soporte.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="lg:col-span-3">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-lg font-bold text-gray-800">Mis Disciplinas Activas</h4>
                        <a href="{{ route('student.enrollments.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition">
                            Ver todo el historial &rarr;
                        </a>
                    </div>

                    @forelse ($enrollments as $enrollment)
                        @php
                            $startDate = $enrollment->start_date ? \Carbon\Carbon::parse($enrollment->start_date) : null;
                            $endDate = $enrollment->end_date ? \Carbon\Carbon::parse($enrollment->end_date) : null;
                        @endphp
                        
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-4 hover:shadow-md transition-shadow">
                            <div class="p-6">
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-12 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-indigo-200">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h5 class="text-xl font-bold text-gray-900">{{ $enrollment->category->name }}</h5>
                                            <p class="text-sm text-indigo-600 font-medium">{{ $enrollment->plan->name ?? 'Plan Estándar' }}</p>
                                        </div>
                                    </div>

                                    <div class="bg-gray-50 px-6 py-3 rounded-2xl text-center md:text-right">
                                        <p class="text-xs text-gray-400 uppercase font-bold tracking-tighter">Tiempo Restante</p>
                                        <p id="countdown-{{ $enrollment->id }}" 
                                           class="text-lg font-mono font-bold text-gray-700"
                                           data-end-date="{{ $endDate?->toIso8601String() }}">
                                            {{ $endDate ? 'Calculando...' : 'Ilimitado' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-6 grid grid-cols-2 md:grid-cols-3 gap-4 border-t border-gray-50 pt-6">
                                    <div>
                                        <p class="text-xs text-gray-400">Fecha Inicio</p>
                                        <p class="text-sm font-semibold text-gray-700">{{ $startDate ? $startDate->format('d/m/Y') : 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400">Próximo Vencimiento</p>
                                        <p class="text-sm font-semibold text-gray-700">{{ $endDate ? $endDate->format('d/m/Y') : 'N/A' }}</p>
                                    </div>
                                    <div class="flex items-center md:justify-end">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest
                                            @if($enrollment->status === 'active') bg-green-100 text-green-700
                                            @elseif($enrollment->status === 'suspended') bg-orange-100 text-orange-700
                                            @else bg-gray-100 text-gray-700 @endif">
                                            {{ $enrollment->status }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white p-12 rounded-3xl border-2 border-dashed border-gray-200 text-center text-gray-500">
                            <p class="text-lg font-medium">No tienes clases activas.</p>
                            <p class="text-sm">Contacta a recepción para inscribirte en una disciplina.</p>
                        </div>
                    @endforelse
                </div>
            </div>
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
                            element.innerHTML = "¡CICLO TERMINADO!";
                            element.classList.replace('text-gray-700', 'text-red-500');
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
