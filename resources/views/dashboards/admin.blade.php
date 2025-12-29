<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📊 Dashboard Administrador
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            {{-- SECCIÓN 1: MÉTRICAS CLAVE FINANCIERAS Y DE INSCRIPCIÓN --}}
            <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">Resumen Financiero y Gestión</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                {{-- 1. Inscripciones Activas --}}
                <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-500">
                    <h3 class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Inscripciones Activas
                    </h3>
                    <p class="text-3xl font-extrabold text-blue-900">{{ $activeEnrollmentsCount ?? 'N/A' }}</p>
                    <p class="text-sm text-gray-500 mt-2">Total de alumnos inscritos en planes vigentes.</p>
                </div>

                {{-- 2. Ingresos del Mes (NUEVO DATO) --}}
                <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500">
                    <h3 class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m0 0l2.55-2.55M7 15l2.55 2.55M17 15l2.55 2.55M17 15l-2.55 2.55m-6 6h4a2 2 0 002-2v-4a2 2 0 00-2-2h-4a2 2 0 00-2 2v4a2 2 0 002 2z"></path></svg>
                        Ingresos (Últimos 30 días)
                    </h3>
                    {{-- Formatear como moneda --}}
                    <p class="text-3xl font-extrabold text-green-700">{{ $monthlyRevenue ?? '$0.00' }}</p> 
                    <p class="text-sm text-gray-500 mt-2">Pagos registrados en el último mes.</p>
                </div>

                {{-- 3. Planes Más Populares (NUEVO DATO) --}}
                <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-yellow-500">
                    <h3 class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-2.485 0-4.5 2.015-4.5 4.5s2.015 4.5 4.5 4.5 4.5-2.015 4.5-4.5-2.015-4.5-4.5-4.5zM12 18V6"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 5H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2z"></path></svg>
                        Planes Más Populares
                    </h3>
                    <p class="text-xl font-bold text-yellow-800">{{ $topPlanName ?? 'N/A' }}</p>
                    <p class="text-sm text-gray-500 mt-2">Con {{ $topPlanCount ?? 0 }} inscripciones activas.</p>
                </div>
                
                {{-- 4. Alumnos con Pago Pendiente (NUEVO DATO) --}}
                <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-red-500">
                    <h3 class="text-sm font-medium text-gray-500 flex items-center">
                         <svg class="w-5 h-5 mr-2 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Pagos Vencidos
                    </h3>
                    <p class="text-3xl font-extrabold text-red-700">{{ $pastDueCount ?? 0 }}</p>
                    <p class="text-sm text-gray-500 mt-2">Inscripciones con pago atrasado (más de 3 días).</p>
                </div>
            </div>

            {{-- SECCIÓN 2: RESUMEN DE USUARIOS --}}
            <h3 class="text-lg font-semibold text-gray-700 border-b pt-4 pb-2">Resumen de Usuarios por Rol</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                
                {{-- 5. Total de Usuarios --}}
                <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-gray-300">
                    <h3 class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.292M21 21v-1a6 6 0 00-9-5.292"></path></svg>
                        Total de Usuarios (Global)
                    </h3>
                    <p class="text-3xl font-extrabold">{{ $totalUsers ?? 0 }}</p>
                    <p class="text-sm text-gray-500 mt-2">Todos los usuarios registrados en el sistema.</p>
                </div>
                
                {{-- 6. Coaches --}}
                <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-purple-500">
                    <h3 class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M7 15c-3.243 0-6 4-6 9v2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c-1.657 0-3-1.343-3-3s1.343-3 3-3 3 1.343 3 3-1.343 3-3 3z"></path></svg>
                        Coaches
                    </h3>
                    <p class="text-3xl font-extrabold text-purple-700">{{ $totalCoaches ?? 0 }}</p>
                    <p class="text-sm text-gray-500 mt-2">Personal con rol de entrenador.</p>
                </div>
                
                {{-- 7. Alumnos --}}
                <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-teal-500">
                    <h3 class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.292M21 21v-1a6 6 0 00-9-5.292"></path></svg>
                        Alumnos Registrados
                    </h3>
                    <p class="text-3xl font-extrabold text-teal-700">{{ $totalStudents ?? 0 }}</p>
                    <p class="text-sm text-gray-500 mt-2">Usuarios con rol de Alumno.</p>
                </div>

                {{-- 8. Administradores --}}
                <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-indigo-500">
                    <h3 class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37a1.724 1.724 0 002.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Administradores
                    </h3>
                    <p class="text-3xl font-extrabold text-indigo-700">{{ $totalAdmins ?? 0 }}</p>
                    <p class="text-sm text-gray-500 mt-2">Personal con privilegios de administrador.</p>
                </div>
            </div>

            {{-- Aquí podríamos agregar tablas de "Últimos Pagos" o "Clases de Hoy" --}}
            <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Próximos Vencimientos de Pago</h3>
                    <p class="text-gray-500">Tabla de inscripciones a vencer en los próximos 7 días.</p>
                    {{-- Tabla o lista de próximos vencimientos (requiere lógica) --}}
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Actividad Reciente</h3>
                    <p class="text-gray-500">Últimos 5 alumnos inscritos recientemente.</p>
                    {{-- Lista de inscripciones recientes (requiere lógica) --}}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>