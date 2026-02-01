@php
    use Illuminate\Support\Facades\Route;
@endphp

<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academia Boxeo | Panel</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Alpine.js --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        [x-cloak] { display: none !important; }
        .custom-scroll::-webkit-scrollbar { width: 4px; }
        .custom-scroll::-webkit-scrollbar-track { background: #0a0a0a; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #ea580c; border-radius: 10px; }
    </style>
</head>

<body class="bg-[#0f0f0f] text-gray-200 font-sans antialiased h-full overflow-hidden"
      x-data="{ sidebarOpen: window.innerWidth >= 1024 }">

<div class="flex h-screen overflow-hidden">

    {{-- Overlay móvil --}}
    <div x-show="sidebarOpen && window.innerWidth < 1024"
         x-transition.opacity x-cloak
         class="fixed inset-0 z-40 bg-black/60 backdrop-blur-sm"
         @click="sidebarOpen = false"></div>

    {{-- ================= SIDEBAR MEJORADO ================= --}}
    <aside
        :class="sidebarOpen ? 'w-64 translate-x-0' : '-translate-x-full lg:w-20 lg:translate-x-0'"
        class="fixed inset-y-0 left-0 z-50 bg-[#0a0a0a] border-r border-white/5 shadow-2xl transition-all duration-300 lg:relative flex flex-col">

        {{-- Header Logo --}}
        <div class="flex items-center justify-between p-5 border-b border-white/5">
            <div class="flex items-center gap-3 overflow-hidden">
                <div class="p-2 bg-orange-600 rounded-lg shrink-0">
                    <i class="fa-solid fa-hand-fist text-black text-lg"></i>
                </div>
                <h1 class="text-sm font-black text-white uppercase tracking-tighter whitespace-nowrap"
                    :class="sidebarOpen ? 'opacity-100' : 'opacity-0 lg:hidden'">
                    Academia <span class="text-orange-600 italic">Box</span>
                </h1>
            </div>
            <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-orange-500 transition-colors">
                <i class="fa-solid fa-bars-staggered"></i>
            </button>
        </div>

        {{-- ================= MENÚ PRINCIPAL ================= --}}
        <nav class="flex-1 px-3 py-6 space-y-2 overflow-y-auto custom-scroll">

            {{-- DASHBOARD --}}
            @if(Route::has('dashboard'))
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all group
                   {{ request()->routeIs('dashboard') ? 'bg-orange-600 text-black font-bold shadow-lg shadow-orange-600/20' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                    <i class="fa-solid fa-house text-lg"></i>
                    <span :class="sidebarOpen ? 'block' : 'hidden lg:hidden'">Dashboard</span>
                </a>
            @endif

            {{-- ================= SECCIÓN ACADÉMICA (TUS VISTAS) ================= --}}
            @if(auth()->user()->hasRole('Admin'))
                <div class="pt-4 pb-2 px-4 text-[10px] uppercase tracking-[0.3em] text-gray-600 font-bold" :class="sidebarOpen ? 'block' : 'hidden lg:hidden'">
                    Académico
                </div>

                <div x-data="{ open: {{ request()->routeIs('alumnos.*', 'docentes.*', 'inscripciones.*', 'horarios.*', 'categorias.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" 
                            class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-gray-400 hover:bg-white/5 hover:text-white transition-all">
                        <div class="flex items-center gap-4">
                            <i class="fa-solid fa-book-open text-lg"></i>
                            <span :class="sidebarOpen ? 'block' : 'hidden lg:hidden'">Gestión</span>
                        </div>
                        <i class="fa-solid fa-chevron-down text-[10px] transition-transform" :class="open ? 'rotate-180' : ''" x-show="sidebarOpen"></i>
                    </button>

                    <div x-show="open" x-collapse x-cloak class="mt-2 space-y-1 pl-4" :class="sidebarOpen ? '' : 'hidden'">
                        @if(Route::has('alumnos.index'))
                            <a href="{{ route('alumnos.index') }}" class="flex items-center gap-3 px-4 py-2 text-sm rounded-lg {{ request()->routeIs('alumnos.*') ? 'text-orange-500 font-bold' : 'text-gray-500 hover:text-white' }}">
                                <i class="fa-solid fa-user-graduate w-4"></i> Alumnos
                            </a>
                        @endif
                        @if(Route::has('docentes.index'))
                            <a href="{{ route('docentes.index') }}" class="flex items-center gap-3 px-4 py-2 text-sm rounded-lg {{ request()->routeIs('docentes.*') ? 'text-orange-500 font-bold' : 'text-gray-500 hover:text-white' }}">
                                <i class="fa-solid fa-chalkboard-user w-4"></i> Docentes
                            </a>
                        @endif
                        @if(Route::has('inscripciones.index'))
                            <a href="{{ route('inscripciones.index') }}" class="flex items-center gap-3 px-4 py-2 text-sm rounded-lg {{ request()->routeIs('inscripciones.*') ? 'text-orange-500 font-bold' : 'text-gray-500 hover:text-white' }}">
                                <i class="fa-solid fa-id-card w-4"></i> Inscripciones
                            </a>
                        @endif
                        @if(Route::has('horarios.index'))
                            <a href="{{ route('horarios.index') }}" class="flex items-center gap-3 px-4 py-2 text-sm rounded-lg {{ request()->routeIs('horarios.*') ? 'text-orange-500 font-bold' : 'text-gray-500 hover:text-white' }}">
                                <i class="fa-solid fa-clock w-4"></i> Horarios
                            </a>
                        @endif
                        @if(Route::has('categorias.index'))
                            <a href="{{ route('categorias.index') }}" class="flex items-center gap-3 px-4 py-2 text-sm rounded-lg {{ request()->routeIs('categorias.*') ? 'text-orange-500 font-bold' : 'text-gray-500 hover:text-white' }}">
                                <i class="fa-solid fa-tag w-4"></i> Categorías
                            </a>
                        @endif
                    </div>
                </div>
            @endif

            {{-- ================= SECCIÓN COMERCIAL (TIENDA E INVENTARIO) ================= --}}
            <div class="pt-4 pb-2 px-4 text-[10px] uppercase tracking-[0.3em] text-gray-600 font-bold" :class="sidebarOpen ? 'block' : 'hidden lg:hidden'">
                Tienda
            </div>

            <div x-data="{ open: false }">
                <button @click="open = !open" 
                        class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-gray-400 hover:bg-white/5 hover:text-white transition-all">
                    <div class="flex items-center gap-4">
                        <i class="fa-solid fa-cart-shopping text-lg"></i>
                        <span :class="sidebarOpen ? 'block' : 'hidden lg:hidden'">Comercial</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-[10px] transition-transform" :class="open ? 'rotate-180' : ''" x-show="sidebarOpen"></i>
                </button>
                <div x-show="open" x-collapse x-cloak class="mt-2 space-y-1 pl-4">
                    <a href="#" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-500 hover:text-white transition-colors">
                        <i class="fa-solid fa-boxes-stacked w-4"></i> Inventario
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-500 hover:text-white transition-colors">
                        <i class="fa-solid fa-receipt w-4"></i> Ventas
                    </a>
                </div>
            </div>

        </nav>

        {{-- FOOTER SIDEBAR --}}
        <div class="p-4 bg-black/40 border-t border-white/5">
            @if(Route::has('profile.edit'))
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center gap-4 px-4 py-2 mb-2 rounded-lg text-xs font-bold text-gray-400 hover:bg-white/5 hover:text-white transition-all">
                    <i class="fa-solid fa-user"></i>
                    <span :class="sidebarOpen ? 'block' : 'hidden lg:hidden'">Perfil</span>
                </a>
            @endif

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-4 px-4 py-2 text-xs font-bold text-red-500 hover:bg-red-500/10 rounded-lg transition-all">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span :class="sidebarOpen ? 'block' : 'hidden lg:hidden'">Cerrar Sesión</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- ================= CONTENIDO PRINCIPAL ================= --}}
    <div class="flex-1 flex flex-col min-w-0">
        
        {{-- Header Superior --}}
        <header class="h-16 flex items-center justify-between px-8 bg-[#0a0a0a] border-b border-white/5 sticky top-0 z-30">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-400">
                    <i class="fa-solid fa-bars-staggered text-xl"></i>
                </button>
                <h2 class="text-xs font-bold uppercase tracking-widest text-gray-500">Panel de Administración</h2>
            </div>
            
            <div class="flex items-center gap-3">
                <span class="text-xs font-medium text-gray-400">{{ auth()->user()->name }}</span>
                <div class="w-8 h-8 rounded-full bg-orange-600 flex items-center justify-center text-black font-black text-[10px]">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            </div>
        </header>

        {{-- Main Content --}}
        <main class="flex-1 overflow-y-auto p-6 bg-[#0f0f0f] custom-scroll">
            <div class="max-w-7xl mx-auto">
                {{ $slot ?? '' }}
                @yield('content')
            </div>
        </main>
    </div>
</div>
</body>
</html>