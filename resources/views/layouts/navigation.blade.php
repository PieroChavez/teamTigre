<nav x-data="{ open: false }" class="bg-white shadow-lg border-b border-gray-100 sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <i class="fa-solid fa-graduation-cap text-indigo-600 text-2xl"></i> 
                        <span class="text-xl font-extrabold text-gray-800 tracking-tight hidden sm:block">
                            {{ config('app.name', 'Laravel') }}
                        </span>
                    </a>
                </div>

                <div class="hidden space-x-2 sm:-my-px sm:ml-8 sm:flex">
                    
                    {{-- 1. Enlace a Dashboard --}}
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="flex items-center gap-2">
                        <i class="fa-solid fa-gauge-high w-4 h-4"></i>
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    {{-- 2. Enlace a Gestión de Alumnos --}}
                    <x-nav-link :href="route('alumnos.index')" :active="request()->routeIs('alumnos.*')" class="flex items-center gap-2">
                        <i class="fa-solid fa-users w-4 h-4"></i> Gestión de Alumnos
                    </x-nav-link>

                    {{-- 3. Académico --}}
                    <x-nav-link :href="route('docentes.index')" :active="request()->routeIs('docentes.*')" class="flex items-center gap-2">
                        <i class="fa-solid fa-chalkboard-user w-4 h-4"></i> Gestión de Docentes
                    </x-nav-link>

                    <x-nav-link :href="route('inscripciones.index')" :active="request()->routeIs('inscripciones.*')" class="flex items-center gap-2">
                        <i class="fa-solid fa-id-card w-4 h-4"></i> Inscripciones
                    </x-nav-link>

                    <x-nav-link :href="route('horarios.index')" :active="request()->routeIs('horarios.*')" class="flex items-center gap-2">
                        <i class="fa-solid fa-clock w-4 h-4"></i> Horarios
                    </x-nav-link>

                    <x-nav-link :href="route('categorias.index')" :active="request()->routeIs('categorias.*')" class="flex items-center gap-2">
                        <i class="fa-solid fa-tag w-4 h-4"></i> Categorías
                    </x-nav-link>

                    {{-- #<x-nav-link :href="route('periodos.index')" :active="request()->routeIs('periodos.*')" class="flex items-center gap-2">
                        <i class="fa-solid fa-calendar-days w-4 h-4"></i> Períodos
                    </x-nav-link> --}}

                    {{-- 4. Finanzas --}}
                    {{-- # Tipos de Pago --}}
                    {{-- <x-nav-link :href="route('tipos_pago.index')" :active="request()->routeIs('tipos_pago.*')" class="flex items-center gap-2">
                        <i class="fa-solid fa-credit-card w-4 h-4"></i> Tipos de Pago
                    </x-nav-link> --}}
                    
                    <x-nav-link :href="route('cuentas.index')" :active="request()->routeIs('cuentas.*')" class="flex items-center gap-2">
                        <i class="fa-solid fa-piggy-bank w-4 h-4"></i> Cuentas
                    </x-nav-link>

                    <x-nav-link :href="route('cuotas.index')" :active="request()->routeIs('cuotas.*')" class="flex items-center gap-2">
                        <i class="fa-solid fa-file-invoice w-4 h-4"></i> Cuotas Pendientes
                    </x-nav-link>

                    {{-- #<x-nav-link :href="route('pagos.index')" :active="request()->routeIs('pagos.*')" class="flex items-center gap-2">
                        <i class="fa-solid fa-file-invoice-dollar w-4 h-4"></i> Pagos
                    </x-nav-link> --}}

                    {{-- 5. Tienda / Ventas --}}
                    {{-- #<x-nav-link :href="route('categorias-productos.index')" :active="request()->routeIs('categorias-productos.*')" class="flex items-center gap-2">
                        <i class="fa-solid fa-tags w-4 h-4"></i> Categorías de Productos
                    </x-nav-link>

                    #<x-nav-link :href="route('productos.index')" :active="request()->routeIs('productos.*')" class="flex items-center gap-2">
                        <i class="fa-solid fa-box-open w-4 h-4"></i> Productos
                    </x-nav-link> --}}

                    <x-nav-link :href="route('ventas.index')" :active="request()->routeIs('ventas.*')" class="flex items-center gap-2">
                        <i class="fa-solid fa-money-check-dollar w-4 h-4"></i> Registro de Ventas
                    </x-nav-link>

                    {{-- #<x-nav-link :href="route('detalle-ventas.index')" :active="request()->routeIs('detalle-ventas.*')" class="flex items-center gap-2">
                        <i class="fa-solid fa-receipt w-4 h-4"></i> Detalle de Ventas
                    </x-nav-link> --}}

                    {{-- 6. Eventos / Otros --}}
                    <x-nav-link :href="route('eventos.index')" :active="request()->routeIs('eventos.*')" class="flex items-center gap-2">
                        <i class="fa-solid fa-calendar-day w-4 h-4"></i> Eventos
                    </x-nav-link>

                    <x-nav-link :href="route('peleadores.index')" :active="request()->routeIs('peleadores.*')" class="flex items-center gap-2">
                        <i class="fa-solid fa-hand-fist w-4 h-4"></i> Peleadores
                    </x-nav-link>

                    <x-nav-link :href="route('noticias.index')" :active="request()->routeIs('noticias.*')" class="flex items-center gap-2">
                        <i class="fa-solid fa-newspaper w-4 h-4"></i> Noticias
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-gray-200 text-sm font-semibold rounded-full text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150 shadow-sm">
                            <div class="truncate max-w-[120px]">{{ Auth::user()->name }}</div>
                            <div class="ml-2">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2">
                            <i class="fa-solid fa-user-circle w-4 h-4"></i>
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();" class="flex items-center gap-2">
                                <i class="fa-solid fa-right-from-bracket w-4 h-4"></i>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-gray-200">
        
        {{-- Enlaces Responsivos --}}
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="flex items-center gap-2">
                <i class="fa-solid fa-gauge-high w-4 h-4"></i> {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('alumnos.index')" :active="request()->routeIs('alumnos.*')" class="flex items-center gap-2">
                <i class="fa-solid fa-users w-4 h-4"></i> Gestión de Alumnos
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('docentes.index')" :active="request()->routeIs('docentes.*')" class="flex items-center gap-2">
                <i class="fa-solid fa-chalkboard-user w-4 h-4"></i> Gestión de Docentes
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('inscripciones.index')" :active="request()->routeIs('inscripciones.*')" class="flex items-center gap-2">
                <i class="fa-solid fa-id-card w-4 h-4"></i> Inscripciones
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('horarios.index')" :active="request()->routeIs('horarios.*')" class="flex items-center gap-2">
                <i class="fa-solid fa-clock w-4 h-4"></i> Horarios
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('categorias.index')" :active="request()->routeIs('categorias.*')" class="flex items-center gap-2">
                <i class="fa-solid fa-tag w-4 h-4"></i> Categorías
            </x-responsive-nav-link>

            {{-- #<x-responsive-nav-link :href="route('periodos.index')" :active="request()->routeIs('periodos.*')" class="flex items-center gap-2">
                <i class="fa-solid fa-calendar-days w-4 h-4"></i> Períodos
            </x-responsive-nav-link> --}}


            <x-responsive-nav-link :href="route('cuotas.index')" :active="request()->routeIs('cuotas.*')" class="flex items-center gap-2">
                <i class="fa-solid fa-file-invoice w-4 h-4"></i> Cuotas Pendientes
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('ventas.index')" :active="request()->routeIs('ventas.*')" class="flex items-center gap-2">
                <i class="fa-solid fa-money-check-dollar w-4 h-4"></i> Registro de Ventas
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('eventos.index')" :active="request()->routeIs('eventos.*')" class="flex items-center gap-2">
                <i class="fa-solid fa-calendar-day w-4 h-4"></i> Eventos
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('peleadores.index')" :active="request()->routeIs('peleadores.*')" class="flex items-center gap-2">
                <i class="fa-solid fa-hand-fist w-4 h-4"></i> Peleadores
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('noticias.index')" :active="request()->routeIs('noticias.*')" class="flex items-center gap-2">
                <i class="fa-solid fa-newspaper w-4 h-4"></i> Noticias
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-bold text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="flex items-center gap-2">
                    <i class="fa-solid fa-user-circle w-4 h-4"></i> {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();" class="flex items-center gap-2">
                        <i class="fa-solid fa-right-from-bracket w-4 h-4"></i> {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
