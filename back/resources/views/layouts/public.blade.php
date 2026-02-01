<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Academia Box'))</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,600,700,800&display=swap" rel="stylesheet" />
    
    {{-- Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes bounce-short {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-4px); }
        }
        .animate-cart {
            animation: bounce-short 2s ease-in-out infinite;
        }
    </style>
</head>
<body class="antialiased bg-white text-slate-900 font-sans">

    {{-- NAVBAR PÚBLICO --}}
    <nav class="fixed w-full z-50 bg-black py-4 px-6 lg:px-12 flex justify-between items-center shadow-2xl border-b border-orange-600/20">
        {{-- LOGO --}}
        <a href="{{ route('home') }}" class="flex items-center gap-2 group">
            <div class="bg-orange-600 p-2 rounded transform group-hover:rotate-12 transition duration-300">
                <i class="fa-solid fa-hand-fist text-black text-xl"></i>
            </div>
            <span class="font-black text-2xl tracking-tighter text-white uppercase">
                Academia<span class="text-orange-600">Box</span>
            </span>
        </a>

        {{-- MENÚ Y ACCIONES --}}
        <div class="flex items-center space-x-4 md:space-x-8">
            {{-- Enlaces de Navegación (Ocultos en móvil, puedes usar un burger luego) --}}
            <div class="hidden md:flex items-center space-x-8 mr-4">
                <a href="{{ route('home') }}" class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-300 hover:text-orange-500 transition">Inicio</a>
                <a href="{{ route('tienda.index') }}" class="text-[10px] font-black uppercase tracking-[0.2em] {{ request()->routeIs('tienda.*') ? 'text-orange-500' : 'text-gray-300' }} hover:text-orange-500 transition">Tienda</a>
            </div>

            {{-- 🛒 ICONO DEL CARRITO DINÁMICO --}}
            <a href="{{ route('carrito.index') }}" class="relative group p-2 flex items-center justify-center transition-transform active:scale-90">
                <i class="fa-solid fa-cart-shopping text-xl text-white group-hover:text-orange-500 transition-colors"></i>
                
                {{-- Contador de sesión --}}
                @php $count = count(session('carrito', [])); @endphp
                @if($count > 0)
                    <span class="absolute -top-1 -right-1 bg-orange-600 text-white text-[9px] font-black w-5 h-5 flex items-center justify-center rounded-full border-2 border-black animate-cart">
                        {{ $count }}
                    </span>
                @endif
            </a>

            <div class="h-6 w-[1px] bg-gray-800 hidden md:block"></div>

            {{-- AUTH --}}
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-orange-600 hover:bg-white text-black px-5 py-2 rounded-lg font-black uppercase text-[10px] tracking-widest transition duration-300 shadow-lg shadow-orange-600/20">
                        Panel
                    </a>
                @else
                    <a href="{{ route('login') }}" class="hidden md:block text-[10px] font-black uppercase tracking-widest text-gray-300 hover:text-orange-500 transition">Login</a>
                    <a href="{{ route('register') }}" class="border-2 border-orange-600 text-orange-600 hover:bg-orange-600 hover:text-black px-5 py-2 rounded-lg font-black uppercase text-[10px] tracking-widest transition duration-300">
                        Únete
                    </a>
                @endauth
            </div>
        </div>
    </nav>
    
    {{-- CONTENIDO DINÁMICO --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-black border-t-4 border-orange-600 text-white py-12 px-6">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="flex flex-col items-center md:items-start gap-2">
                <span class="font-black text-2xl uppercase italic leading-none">Academia<span class="text-orange-600">Box</span></span>
                <p class="text-gray-500 text-[9px] tracking-[0.3em] uppercase font-bold">Entrenamiento de Élite</p>
            </div>
            
            <p class="text-gray-500 text-[10px] tracking-[0.4em] uppercase order-3 md:order-2">© {{ date('Y') }} — No pain no gain.</p>
            
            <div class="flex gap-6 text-xl order-2 md:order-3">
                <a href="#" class="text-gray-400 hover:text-orange-600 transition-colors"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" class="text-gray-400 hover:text-orange-600 transition-colors"><i class="fa-brands fa-facebook"></i></a>
                <a href="https://wa.me/51947637782" target="_blank" class="text-gray-400 hover:text-orange-600 transition-colors"><i class="fa-brands fa-whatsapp"></i></a>
            </div>
        </div>
    </footer>

</body>
</html>