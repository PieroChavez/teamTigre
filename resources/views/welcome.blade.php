<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Incluir assets compilados si existen -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen flex items-center justify-center">
    <div class="text-center">
        <h1 class="text-4xl font-bold mb-4">Bienvenido a {{ config('app.name', 'Laravel') }}</h1>
        <p class="mb-6">Esta es una página de bienvenida simplificada.</p>
        
        <!-- Navegación condicional -->
        @if (Route::has('login'))
            <nav class="flex justify-center gap-4 mb-6">
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-4 py-2 bg-blue-500 text-white rounded">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Iniciar Sesión</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-green-500 text-white rounded">Registrarse</a>
                    @endif
                @endauth
            </nav>
        @endif
        
        <p>Si necesitas personalizar esta página, edítala aquí.</p>
    </div>
</body>
</html>
