<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Academia Box'))</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,600,700,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', sans-serif; }
        .glass-nav {
            background: rgba(0, 0, 0, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(249, 115, 22, 0.3);
        }
    </style>
</head>
<body class="antialiased bg-white text-slate-900">

    {{-- ================= NAVBAR MEJORADO ================= --}}
    <nav x-data="{ open: false, atTop: true }" 
         @scroll.window="atTop = (window.pageYOffset > 10 ? false : true)"
         :class="{ 'glass-nav py-3 shadow-2xl': !atTop, 'bg-black py-5': atTop }"
         class="fixed w-full z-50 transition-all duration-300 px-6 lg:px-12 flex justify-between items-center">
        
        {{-- LOGO Y NOMBRE JUNTOS --}}
        <a href="/" class="flex items-center gap-4 group">
            <div class="relative">
                <div class="absolute -inset-1 bg-orange-600 rounded-full opacity-20 group-hover:opacity-50 blur transition"></div>
                <img src="{{ asset('images/logo.png') }}" 
                     alt="Logo Academia Box" 
                     class="relative w-12 h-12 object-contain transform group-hover:scale-110 transition-transform duration-300">
            </div>
            <div class="flex flex-col">
                <span class="font-black text-2xl tracking-tighter text-white uppercase leading-none">
                    Academia<span class="text-orange-600 italic">Box</span>
                </span>
                <span class="text-[8px] font-bold text-orange-500 uppercase tracking-[0.3em] leading-none mt-1">
                    El Tigre
                </span>
            </div>
        </a>

        {{-- Desktop Menu --}}
        <div class="hidden md:flex items-center space-x-8">
            <a href="{{ route('home') }}" 
               class="text-[10px] font-black uppercase tracking-[0.2em] {{ request()->routeIs('home') ? 'text-orange-500' : 'text-gray-400' }} hover:text-orange-500 transition-colors">
                Inicio
            </a>
            
            <a href="{{ route('tienda.index') }}" 
               class="text-[10px] font-black uppercase tracking-[0.2em] {{ request()->routeIs('tienda.index*') ? 'text-orange-500' : 'text-gray-400' }} hover:text-orange-500 transition-colors">
                Tienda
            </a>

            <a href="#" class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 hover:text-orange-500 transition-colors">Eventos</a>
            
            <div class="h-4 w-[1px] bg-white/10"></div>

            @if (Route::has('login'))
                @auth
                    <a href="{{ route('dashboard') }}" 
                       class="bg-orange-600 hover:bg-white text-black px-6 py-2 rounded-lg font-black uppercase text-[10px] tracking-widest transition-all duration-300 shadow-lg shadow-orange-600/20">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-[10px] font-black uppercase tracking-[0.2em] text-white hover:text-orange-500 transition-colors">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" 
                           class="border-2 border-orange-600 text-orange-600 hover:bg-orange-600 hover:text-black px-6 py-2 rounded-lg font-black uppercase text-[10px] tracking-widest transition-all duration-300">
                            Únete
                        </a>
                    @endif
                @endauth
            @endif
        </div>

        {{-- Mobile Toggle --}}
        <button @click="open = !open" class="md:hidden text-orange-600 text-2xl">
            <i :class="open ? 'fa-solid fa-xmark' : 'fa-solid fa-bars-staggered'"></i>
        </button>

        {{-- Mobile Menu --}}
        <div x-show="open" x-cloak 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="absolute top-full left-0 w-full bg-black border-t border-orange-600/30 p-8 flex flex-col space-y-6 md:hidden shadow-2xl">
            <a href="/" class="text-white font-black uppercase tracking-widest text-sm hover:text-orange-600">Inicio</a>
            <a href="{{ route('tienda.index') }}" class="text-white font-black uppercase tracking-widest text-sm hover:text-orange-600">Tienda</a>
            <a href="#" class="text-white font-black uppercase tracking-widest text-sm hover:text-orange-600">Eventos</a>
            <hr class="border-gray-800">
            @auth
                <a href="{{ route('dashboard') }}" class="text-orange-600 font-black uppercase tracking-widest text-sm">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="text-white font-black uppercase tracking-widest text-sm">Login</a>
                <a href="{{ route('register') }}" class="text-orange-600 font-black uppercase tracking-widest text-sm">Registro</a>
            @endauth
        </div>
    </nav>
    
    {{-- ================= CONTENIDO ================= --}}
    <main class="min-h-screen">
        {{-- Quitamos el BG-BLACK fijo para que el welcome fluya mejor --}}
        @yield('content')
    </main>

    {{-- ================= FOOTER ================= --}}
    <footer class="bg-[#050505] border-t border-white/5 text-white pt-20 pb-10 px-6">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-12 mb-20">
            <div class="md:col-span-2 space-y-6">
                <span class="font-black text-3xl tracking-tighter uppercase leading-none text-white">
                    Academia<span class="text-orange-600">Box</span>
                </span>
                <p class="text-gray-500 text-sm leading-relaxed max-w-sm italic font-medium">
                    "No es solo boxeo, es disciplina. Entrenamos con los estándares más altos para convertirte en tu mejor versión."
                </p>
                <div class="flex gap-4 pt-4">
                    <a href="#" class="w-10 h-10 bg-white/5 border border-white/10 flex items-center justify-center rounded-lg hover:bg-orange-600 hover:text-black transition-all">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-white/5 border border-white/10 flex items-center justify-center rounded-lg hover:bg-orange-600 hover:text-black transition-all">
                        <i class="fa-brands fa-tiktok"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-white/5 border border-white/10 flex items-center justify-center rounded-lg hover:bg-orange-600 hover:text-black transition-all">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                </div>
            </div>
            
            <div>
                <h4 class="font-black uppercase tracking-[0.2em] text-[10px] text-orange-600 mb-8">Explorar</h4>
                <ul class="space-y-4 text-xs font-bold text-gray-400 uppercase tracking-widest">
                    <li><a href="#" class="hover:text-white transition">Nuestras Sedes</a></li>
                    <li><a href="#" class="hover:text-white transition">Planes</a></li>
                    <li><a href="{{ route('tienda.index') }}" class="hover:text-white transition text-orange-600">Tienda Oficial</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-black uppercase tracking-[0.2em] text-[10px] text-orange-600 mb-8">Soporte</h4>
                <ul class="space-y-4 text-xs font-bold text-gray-400 uppercase tracking-widest">
                    <li><a href="#" class="hover:text-white transition">Contacto</a></li>
                    <li><a href="#" class="hover:text-white transition">Privacidad</a></li>
                    <li><a href="#" class="hover:text-white transition">Términos</a></li>
                </ul>
            </div>
        </div>

        <div class="max-w-7xl mx-auto border-t border-white/5 pt-10 flex flex-col md:flex-row justify-between items-center gap-6">
            <p class="text-[9px] text-gray-600 uppercase tracking-[0.5em] font-black">
                © {{ date('Y') }} Academia Box — Power by Laravel 12.
            </p>
        </div>
    </footer>

</body>
</html>