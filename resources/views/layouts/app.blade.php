<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin - Escuela de Box')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
</head>

<body class="bg-gray-100">

<div class="flex min-h-screen">

    <!-- ============ SIDEBAR ============ -->
    <aside id="sidebar"
        class="fixed inset-y-0 left-0 z-40
               w-64 bg-indigo-600
               transition-all duration-300
               flex flex-col">

        <!-- LOGO -->
        <div class="flex items-center gap-3 px-6 py-4 text-white font-bold text-lg">
            <img src="{{ asset('img/logo.png') }}" class="h-8 shrink-0">
            <span class="sidebar-text whitespace-nowrap">Panel Admin</span>
        </div>

        <!-- MENU -->
        <nav class="mt-6 px-3 space-y-2 flex-1">

            <a href="{{ route('home') }}"
               class="flex items-center gap-4 px-4 py-3 rounded-lg text-white hover:bg-indigo-500">
                <i class="fas fa-home w-6 text-center"></i>
                <span class="sidebar-text">Dashboard</span>
            </a>

            <a href="{{ route('alumnos.index') }}"
               class="flex items-center gap-4 px-4 py-3 rounded-lg text-white hover:bg-indigo-500">
                <i class="fas fa-users w-6 text-center"></i>
                <span class="sidebar-text">Alumnos</span>
            </a>

            <a href="{{ route('asistencias.index') }}"
               class="flex items-center gap-4 px-4 py-3 rounded-lg text-white hover:bg-indigo-500">
                <i class="fas fa-calendar-check w-6 text-center"></i>
                <span class="sidebar-text">Asistencias</span>
            </a>

            <a href="{{ route('eventos.index') }}"
               class="flex items-center gap-4 px-4 py-3 rounded-lg text-white hover:bg-indigo-500">
                <i class="fas fa-calendar-alt w-6 text-center"></i>
                <span class="sidebar-text">Eventos</span>
            </a>

            <a href="{{ route('noticias.index') }}"
               class="flex items-center gap-4 px-4 py-3 rounded-lg text-white hover:bg-indigo-500">
                <i class="fas fa-newspaper w-6 text-center"></i>
                <span class="sidebar-text">Noticias</span>
            </a>
        </nav>

        <!-- BOTÓN COLAPSAR (ABAJO) -->
        <button id="toggleSidebar"
            class="flex items-center justify-center
                   py-4 text-white hover:bg-indigo-500">
            <i id="arrowIcon" class="fas fa-angle-left text-xl"></i>
        </button>
    </aside>

    <!-- ============ MAIN ============ -->
    <div id="mainContent"
         class="flex-1 ml-64 transition-all duration-300">

        <!-- TOP BAR -->
        <header class="flex items-center justify-between bg-white px-6 py-4 shadow-sm">

            <button id="openSidebarMobile"
                    class="lg:hidden text-gray-600">
                <i class="fas fa-bars text-xl"></i>
            </button>

            <h1 class="text-lg font-semibold text-gray-700">
                @yield('title', 'Dashboard')
            </h1>

            @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-red-600 hover:underline">
                    Cerrar sesión
                </button>
            </form>
            @endauth
        </header>

        <main class="p-6">
            @yield('content')
        </main>
    </div>
</div>

<!-- OVERLAY MOBILE -->
<div id="overlay"
     class="fixed inset-0 bg-black/50 hidden z-30 lg:hidden"></div>

<!-- SCRIPT -->
<script>
    const sidebar = document.getElementById('sidebar');
    const main = document.getElementById('mainContent');
    const toggle = document.getElementById('toggleSidebar');
    const arrow = document.getElementById('arrowIcon');
    const texts = document.querySelectorAll('.sidebar-text');

    let collapsed = false;

    toggle.addEventListener('click', () => {
        collapsed = !collapsed;

        sidebar.classList.toggle('w-64');
        sidebar.classList.toggle('w-20');

        main.classList.toggle('ml-64');
        main.classList.toggle('ml-20');

        texts.forEach(text => {
            text.classList.toggle('hidden');
        });

        arrow.classList.toggle('fa-angle-left');
        arrow.classList.toggle('fa-angle-right');
    });

    // MOBILE
    const openMobile = document.getElementById('openSidebarMobile');
    const overlay = document.getElementById('overlay');

    openMobile?.addEventListener('click', () => {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    });
</script>

</body>
</html>
