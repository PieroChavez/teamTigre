<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-3xl text-white leading-tight tracking-tighter flex items-center gap-3">
            <div class="p-2 bg-orange-500/10 rounded-xl">
                <i class="fa-solid fa-chart-line text-orange-500 shadow-sm"></i>
            </div>
            DASHBOARD GENERAL
        </h2>
    </x-slot>

    <div class="py-10 bg-[#050505] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- 1. Tarjetas de Resumen Estilo Neón --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                {{-- Usuarios --}}
                <div class="bg-[#0a0a0a] border border-white/5 rounded-3xl p-6 relative overflow-hidden group transition-all duration-300 hover:border-orange-500/30">
                    <div class="absolute -top-6 -right-6 h-24 w-24 bg-orange-500/10 rounded-full blur-2xl group-hover:bg-orange-500/20 transition-all"></div>
                    
                    <div class="flex items-center justify-between mb-4 relative z-10">
                        <div>
                            <h2 class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500">Total Usuarios</h2>
                            <p class="text-5xl font-black text-white mt-1">{{ $totalUsuarios }}</p>
                        </div>
                        <div class="bg-orange-500/10 p-4 rounded-2xl text-orange-500">
                            <i class="fa-solid fa-users text-2xl"></i>
                        </div>
                    </div>

                    <div class="w-full bg-white/5 rounded-full h-1.5 mt-6">
                        <div class="bg-orange-500 h-1.5 rounded-full shadow-[0_0_10px_#f97316]" style="width: 70%"></div>
                    </div>
                    <p class="text-[10px] mt-3 font-bold text-gray-600 uppercase tracking-widest">70% del objetivo mensual</p>
                </div>

                {{-- Docentes --}}
                <div class="bg-[#0a0a0a] border border-white/5 rounded-3xl p-6 relative overflow-hidden group transition-all duration-300 hover:border-green-500/30">
                    <div class="absolute -top-6 -right-6 h-24 w-24 bg-green-500/10 rounded-full blur-2xl group-hover:bg-green-500/20 transition-all"></div>
                    
                    <div class="flex items-center justify-between mb-4 relative z-10">
                        <div>
                            <h2 class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500">Docentes Activos</h2>
                            <p class="text-5xl font-black text-white mt-1">{{ $totalDocentes }}</p>
                        </div>
                        <div class="bg-green-500/10 p-4 rounded-2xl text-green-500">
                            <i class="fa-solid fa-chalkboard-user text-2xl"></i>
                        </div>
                    </div>

                    <div class="w-full bg-white/5 rounded-full h-1.5 mt-6">
                        <div class="bg-green-500 h-1.5 rounded-full shadow-[0_0_10px_#22c55e]" style="width: 85%"></div>
                    </div>
                    <p class="text-[10px] mt-3 font-bold text-gray-600 uppercase tracking-widest">85% capacidad de clases</p>
                </div>

                {{-- Periodos --}}
                <div class="bg-[#0a0a0a] border border-white/5 rounded-3xl p-6 relative overflow-hidden group transition-all duration-300 hover:border-indigo-500/30">
                    <div class="absolute -top-6 -right-6 h-24 w-24 bg-indigo-500/10 rounded-full blur-2xl group-hover:bg-indigo-500/20 transition-all"></div>
                    
                    <div class="flex items-center justify-between mb-4 relative z-10">
                        <div>
                            <h2 class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500">Periodos Abiertos</h2>
                            <p class="text-5xl font-black text-white mt-1">{{ $totalPeriodos }}</p>
                        </div>
                        <div class="bg-indigo-500/10 p-4 rounded-2xl text-indigo-500">
                            <i class="fa-solid fa-calendar-check text-2xl"></i>
                        </div>
                    </div>

                    <div class="w-full bg-white/5 rounded-full h-1.5 mt-6">
                        <div class="bg-indigo-500 h-1.5 rounded-full shadow-[0_0_10px_#6366f1]" style="width: 50%"></div>
                    </div>
                    <p class="text-[10px] mt-3 font-bold text-gray-600 uppercase tracking-widest">50% ciclos finalizados</p>
                </div>
            </div>

            {{-- 2. Gráfico Premium --}}
            <div class="bg-[#0a0a0a] border border-white/5 shadow-2xl rounded-3xl p-8">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-xs font-black uppercase tracking-[0.3em] text-orange-500 flex items-center gap-3">
                        <i class="fa-solid fa-chart-simple text-lg"></i>
                        Análisis de Actividad Mensual
                    </h2>
                </div>
                <div class="h-80 w-full">
                    <canvas id="usuariosChart"></canvas>
                </div>
            </div>

            {{-- 3. Últimos Registros --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                {{-- Últimos Alumnos --}}
                <div class="bg-[#0a0a0a] border border-white/5 rounded-3xl p-6">
                    <h2 class="text-[10px] font-black uppercase tracking-[0.3em] mb-6 text-green-500 flex items-center gap-2">
                        <i class="fa-solid fa-user-plus text-sm"></i>
                        Ingresos Recientes: Alumnos
                    </h2>

                    <div class="space-y-3">
                        @forelse($ultimosAlumnos as $alumno)
                            <div class="group flex items-center justify-between p-4 bg-white/[0.02] border border-white/5 rounded-2xl hover:bg-white/[0.04] transition-all duration-300">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 bg-green-500/10 rounded-xl flex items-center justify-center text-green-500 font-bold">
                                        {{ substr($alumno->nombre, 0, 1) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-black text-gray-200 uppercase tracking-tight">{{ $alumno->nombre }}</span>
                                        <span class="text-[10px] font-bold text-gray-600 tracking-widest">{{ $alumno->email ?? 'SIN EMAIL' }}</span>
                                    </div>
                                </div>
                                <i class="fa-solid fa-chevron-right text-[10px] text-white/10 group-hover:text-green-500 group-hover:translate-x-1 transition-all"></i>
                            </div>
                        @empty
                            <div class="py-10 text-center text-gray-600 font-bold uppercase text-[10px] tracking-widest">Sin registros</div>
                        @endforelse
                    </div>
                </div>

                {{-- Últimos Docentes --}}
                <div class="bg-[#0a0a0a] border border-white/5 rounded-3xl p-6">
                    <h2 class="text-[10px] font-black uppercase tracking-[0.3em] mb-6 text-indigo-500 flex items-center gap-2">
                        <i class="fa-solid fa-shield-halved text-sm"></i>
                        Staff: Últimos Docentes
                    </h2>

                    <div class="space-y-3">
                        @forelse($ultimosDocentes as $docente)
                            <div class="group flex items-center justify-between p-4 bg-white/[0.02] border border-white/5 rounded-2xl hover:bg-white/[0.04] transition-all duration-300">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 bg-indigo-500/10 rounded-xl flex items-center justify-center text-indigo-500 font-bold">
                                        <i class="fa-solid fa-user-tie text-xs"></i>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-black text-gray-200 uppercase tracking-tight">{{ $docente->user->name ?? 'N/A' }}</span>
                                        <span class="text-[10px] font-bold text-gray-500 italic">{{ $docente->especialidad }}</span>
                                    </div>
                                </div>
                                <i class="fa-solid fa-chevron-right text-[10px] text-white/10 group-hover:text-indigo-500 group-hover:translate-x-1 transition-all"></i>
                            </div>
                        @empty
                            <div class="py-10 text-center text-gray-600 font-bold uppercase text-[10px] tracking-widest">Sin registros</div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Chart Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('usuariosChart').getContext('2d');
            
            // Gradiente para el gráfico
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(249, 115, 22, 0.4)');
            gradient.addColorStop(1, 'rgba(249, 115, 22, 0)');

            new Chart(ctx, {
                type: 'line', // Cambiado a línea para un look más Pro
                data: {
                    labels: {!! json_encode(array_keys($usuariosPorMes->toArray())) !!},
                    datasets: [{
                        label: 'USUARIOS NUEVOS',
                        data: {!! json_encode(array_values($usuariosPorMes->toArray())) !!},
                        borderColor: '#F97316',
                        borderWidth: 4,
                        pointBackgroundColor: '#F97316',
                        pointBorderColor: '#050505',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        fill: true,
                        backgroundColor: gradient,
                        tension: 0.4 // Curva suave
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: { 
                            grid: { color: 'rgba(255, 255, 255, 0.05)', drawBorder: false },
                            ticks: { color: '#4b5563', font: { weight: 'bold', size: 10 } }
                        },
                        x: { 
                            grid: { display: false },
                            ticks: { color: '#4b5563', font: { weight: 'bold', size: 10 } }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>