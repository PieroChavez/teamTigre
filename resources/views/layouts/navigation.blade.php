<nav x-data="{ open: false }" class="flex flex-col h-full bg-white border-r border-gray-100 shadow-sm">
    <div class="flex flex-col flex-1 p-4"> 
        
        {{-- Cabecera del Nav: Logo y Botón Móvil --}}
        <div class="flex items-center justify-between mb-4 md:mb-6">
            <div class="shrink-0 flex items-center">
                <a href="{{ route('redirect.by.role') }}">
                    <x-application-logo class="block h-10 w-auto fill-current text-gray-800" />
                </a>
            </div>

            {{-- Botón Hamburguesa (Solo móvil) --}}
            <div class="flex items-center md:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Contenedor Principal de Enlaces --}}
        <div :class="{'block': open, 'hidden': ! open}" class="md:flex flex-col flex-1 space-y-1 hidden"> 
            @php
                $role = optional(auth()->user()->role)->name;
            @endphp

            <div class="flex-1 space-y-1"> 
                
                {{-- SECCIÓN ADMIN --}}
                @if ($role === 'admin')
                    {{-- 🎯 GRUPO PRINCIPAL --}}
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="flex items-center py-2 px-3 rounded-md transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Dashboard
                    </x-nav-link>

                    {{-- 🎯 GRUPO 1: Gestión de Personas --}}
                    <h4 class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-widest mt-4 pt-4 border-t border-gray-100">
                        Gestión de Personas
                    </h4>
                    
                    <x-nav-link :href="route('admin.coaches.index')" :active="request()->routeIs('admin.coaches.*')" class="flex items-center py-2 px-3 rounded-md transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M7 15c-3.243 0-6 4-6 9v2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c-1.657 0-3-1.343-3-3s1.343-3 3-3 3 1.343 3 3-1.343 3-3 3z"></path></svg>
                        Entrenadores
                    </x-nav-link>

                    <x-nav-link :href="route('admin.students.index')" :active="request()->routeIs('admin.students.*')" class="flex items-center py-2 px-3 rounded-md transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.292M21 21v-1a6 6 0 00-9-5.292"></path></svg>
                        Alumnos
                    </x-nav-link>
                    
                    {{-- 🎯 GRUPO 2: Configuración de Servicios --}}
                    <h4 class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-widest mt-4">
                        Servicios y Precios
                    </h4>

                    <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')" class="flex items-center py-2 px-3 rounded-md transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        Categorías
                    </x-nav-link>

                    <x-nav-link :href="route('admin.plans.index')" :active="request()->routeIs('admin.plans.*')" class="flex items-center py-2 px-3 rounded-md transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6m10-12V7a2 2 0 00-2-2H9a2 2 0 00-2 2v4m10 4v4a2 2 0 01-2 2h-4a2 2 0 01-2-2v-4"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14-8v8"></path></svg>
                        Planes
                    </x-nav-link>

                    {{-- 🎯 GRUPO 3: Movimientos y Finanzas --}}
                    <h4 class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-widest mt-4">
                        Finanzas y Registros
                    </h4>

                    <x-nav-link :href="route('admin.enrollments.index')" :active="request()->routeIs('admin.enrollments.*')" class="flex items-center py-2 px-3 rounded-md transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Inscripciones
                    </x-nav-link>

                    <x-nav-link :href="route('admin.payments.index')" :active="request()->routeIs('admin.payments.*')" class="flex items-center py-2 px-3 rounded-md transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m0 0l2.55-2.55M7 15l2.55 2.55M17 15l2.55 2.55M17 15l-2.55 2.55m-6 6h4a2 2 0 002-2v-4a2 2 0 00-2-2h-4a2 2 0 00-2 2v4a2 2 0 002 2z"></path></svg>
                        Pagos
                    </x-nav-link>
                @endif

                {{-- SECCIÓN ALUMNO --}}
                @if ($role === 'alumno')
                    <x-nav-link :href="route('student.dashboard')" :active="request()->routeIs('student.dashboard')" class="flex items-center py-2 px-3 rounded-md transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Mi Portal
                    </x-nav-link>
                    
                    <h4 class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-widest mt-4">
                        Mi Cuenta
                    </h4>

                    <x-nav-link :href="route('student.enrollments.index')" :active="request()->routeIs('student.enrollments.index')" class="flex items-center py-2 px-3 rounded-md transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Mis Inscripciones
                    </x-nav-link>
                    
                    <x-nav-link :href="route('student.attendance.history')" :active="request()->routeIs('student.attendance.history')" class="flex items-center py-2 px-3 rounded-md transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h.01M16 11h.01M21 12c0 4.714-2.583 8.35-6.505 10S7.583 20.714 3 16s2.583-8.35 6.505-10C15.417 4.35 21 7.286 21 12z"></path></svg>
                        Mi Asistencia
                    </x-nav-link>
                    
                    <x-nav-link :href="route('student.payments.history')" :active="request()->routeIs('student.payments.history')" class="flex items-center py-2 px-3 rounded-md transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-2.485 0-4.5 2.015-4.5 4.5s2.015 4.5 4.5 4.5 4.5-2.015 4.5-4.5-2.015-4.5-4.5-4.5zM12 18V6"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 5H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2z"></path></svg>
                        Mis Pagos
                    </x-nav-link>
                @endif

                {{-- SECCIÓN COACH --}}
                @if ($role === 'coach')
                    <x-nav-link :href="route('coach.dashboard')" :active="request()->routeIs('coach.dashboard')" class="flex items-center py-2 px-3 rounded-md transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Mis Alumnos
                    </x-nav-link>
                    {{-- Si hay más enlaces para el coach, se añaden aquí --}}
                @endif
            </div>

            {{-- Pie del Menú: Perfil y Salir --}}
            <div class="mt-auto pt-4 border-t border-gray-100">
                <div class="px-3 py-4 bg-gray-50/50"> 
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Rol: {{ ucfirst($role) }}</p>
                    <p class="text-base font-semibold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                </div>
                
                <x-nav-link :href="route('profile.edit')" class="flex items-center py-2 px-3 rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Perfil
                </x-nav-link>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center py-2 px-3 rounded-md text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Salir
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>