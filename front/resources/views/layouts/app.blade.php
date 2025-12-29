<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'El Tigre') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">

    {{-- Contenedor principal --}}
    <div class="min-h-screen flex flex-col md:flex-row"> 
        
        {{-- 1. BARRA DE NAVEGACIÓN --}}
        <aside class="w-full md:w-64 bg-white shadow-xl md:min-h-screen border-r border-gray-100 sticky top-0 z-50">
            @include('layouts.navigation')
        </aside>

        {{-- 2. CONTENIDO PRINCIPAL --}}
        <div class="flex-1 flex flex-col min-w-0">
            
            @isset($header)
                <header class="bg-white shadow-sm border-b border-gray-100">
                    <div class="max-w-full mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <div class="text-xl font-semibold text-gray-800">
                            {{ $header }}
                        </div>
                    </div>
                </header>
            @endisset

            <main class="p-4 sm:p-6 lg:p-8">
                {{ $slot }}
            </main>
        </div>
        
    </div>



</body>
</html>
