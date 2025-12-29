<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Escuela de Box El Tigre') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> {{-- Aseguramos Font Awesome --}}

        {{-- Asegúrate de que Alpine.js esté incluido aquí por el @vite --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    
    {{-- AÑADIMOS ALPINE.JS y el estado de la barra lateral --}}
    <body class="font-sans text-gray-900 antialiased bg-gray-100" x-data="{ sidebarOpen: false }">
        
        <div class="flex min-h-screen">

            {{-- 🎯 COLUMNA 1: MENÚ LATERAL OCULTO/EXPANDIBLE (SIDEBAR) --}}
            <aside 
                class="bg-gray-800 text-white flex flex-col shadow-xl fixed h-full z-30 transition-all duration-300 ease-in-out" 
                :class="sidebarOpen ? 'w-64' : 'w-20'"
                x-on:mouseenter="sidebarOpen = true"
                x-on:mouseleave="sidebarOpen = false"
            >
                
                {{-- Logo/Título --}}
                <div class="shrink-0 flex items-center p-6 border-b border-gray-700 h-20">
                    <a href="/" class="flex items-center w-full">
                        {{-- 🌟 Icono del logo Naranja --}}
                        <x-application-logo class="w-8 h-8 fill-current text-orange-400" /> 
                        {{-- El texto solo se muestra si la barra está abierta --}}
                        <span 
                            class="ml-3 font-bold text-xl transition-opacity duration-300 ease-in-out"
                            :class="sidebarOpen ? 'opacity-100' : 'opacity-0'"
                            x-cloak>
                            {{ config('app.name', 'Escuela de Box El Tigre') }}
                        </span> 
                    </a>
                </div>
                
                {{-- ENLACES DE NAVEGACIÓN PÚBLICA --}}
                <nav class="flex-1 p-4 space-y-2">
                    
                    @php
                        // Función para determinar si el enlace está activo
                        // 🌟 CLASE ACTIVA Naranja: bg-orange-600
                        $isActive = fn($route) => request()->routeIs($route) ? 'bg-orange-600 text-white' : 'text-gray-300 hover:bg-gray-700';
                    @endphp

                    {{-- Enlaces de Navegación --}}
                    @include('layouts.partials.sidebar-link', ['route' => 'welcome', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'label' => 'Inicio', 'isActive' => $isActive('welcome')])
                    
                    {{-- 🔄 CAMBIO: 'Clases' a 'Categorías' --}}
                    @include('layouts.partials.sidebar-link', ['route' => 'clases', 'icon' => 'M11 20H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2v6m-7 8l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3v-4m-4 0h18', 'label' => 'Categorías', 'isActive' => $isActive('clases')])

                    {{-- ➕ NUEVO BOTÓN: EVENTOS --}}
                    @include('layouts.partials.sidebar-link', ['route' => 'eventos', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'label' => 'Eventos', 'isActive' => $isActive('eventos')])
                    
                    @include('layouts.partials.sidebar-link', ['route' => 'planes', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.35 2.76 1A2.96 2.96 0 0012 8zm0 0v-4m0 8v4m0 0a9 9 0 100-18 9 9 0 000 18z', 'label' => 'Precios & Planes', 'isActive' => $isActive('planes')])
                    
                    <hr class="border-gray-700 my-4">

                    {{-- 🌟 Botón de Acceso Clientes Naranja --}}
                    @include('layouts.partials.sidebar-link', ['route' => 'login', 'icon' => 'M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3v-4m-4 0h18', 'label' => 'Acceso Clientes', 'color' => 'bg-orange-600 hover:bg-orange-700'])
                </nav>
            </aside>
            
            {{-- 🎯 COLUMNA 2: CONTENIDO PRINCIPAL (BODY) --}}
            <main 
                class="flex-1 p-0 transition-all duration-300 ease-in-out" 
                :class="sidebarOpen ? 'ml-64' : 'ml-20'">
                
                {{-- Contenido de la Página (Slot: Aquí es donde se inyecta welcome.blade.php, etc.) --}}
                {{ $slot }}
                
                {{-- ************************************************* --}}
                {{-- 6. CALL TO ACTION FINAL --}}
                {{-- ************************************************* --}}
                <div class="bg-orange-700"> {{-- 🌟 Fondo Naranja --}}
                    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
                        <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                            <span class="block">¡No esperes más!</span>
                            {{-- 🌟 Subtítulo Blanco/Naranja claro --}}
                            <span class="block text-orange-200">Empieza tu entrenamiento hoy mismo.</span>
                        </h2>
                        <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                            <div class="inline-flex rounded-md shadow">
                                {{-- Botón final Blanco --}}
                                <a href="/register" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-orange-600 bg-white hover:bg-orange-50 transition-colors">
                                    Inscribirme Ahora
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </main>
        </div>

        
        
    </body>
</html>