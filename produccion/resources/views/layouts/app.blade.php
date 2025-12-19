<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin - Escuela de Box')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Bootstrap CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    {{-- Font Awesome (Necesario para los íconos) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    {{-- 🛑 ESTA LÍNEA CARGA TUS ESTILOS PERSONALIZADOS 🛑 --}}
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    <!-- Tailwind CSS CDN (Opcional, si usas Tailwind en tu proyecto) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container-fluid container">
        
        {{-- Navbar Brand con Logo --}}
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            {{-- Asegúrate de que public/img/logo.png exista --}}
            <img src="{{ asset('img/logo.png') }}" 
                 alt="Logo Escuela de Box" 
                 style="height: 30px; margin-right: 8px;"
                 class="d-inline-block align-text-top">
            <span class="d-none d-sm-inline">Panel de Control</span>
            
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            
            {{-- Enlaces Principales del Panel --}}
            <div class="d-flex align-items-center gap-2 ms-lg-auto">
                
                <div class="d-flex gap-2">
                    <a class="btn btn-outline-light btn-sm" href="{{ route('alumnos.index') }}" title="Alumnos">
                       <i class="fas fa-users"></i> <span class="d-none d-xl-inline">Alumnos</span>
                    </a>
                    <a class="btn btn-outline-light btn-sm" href="{{ route('asistencias.index') }}" title="Asistencia">
                       <i class="fas fa-calendar-check"></i> <span class="d-none d-xl-inline">Asistencia</span>
                    </a>
                    <a class="btn btn-outline-light btn-sm" href="{{ route('eventos.index') }}" title="Eventos">
                       <i class="fas fa-calendar-alt"></i> <span class="d-none d-xl-inline">Eventos</span>
                    </a>
                    <a class="btn btn-outline-light btn-sm" href="{{ route('noticias.index') }}" title="Noticias">
                       <i class="fas fa-newspaper"></i> <span class="d-none d-xl-inline">Noticias</span>
                    </a>
                </div>

                {{-- Botón de LOGOUT --}}
                @auth
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                        </button>
                    </form>
                @endauth
                
            </div>
        </div>
    </div>
</nav>

<div class="container mt-4">

    {{-- Mensajes de Sesión (Success/Error) --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Contenido de la Vista (Dashboard, Alumnos, etc.) --}}
    @yield('content')

</div>

{{-- Script de Bootstrap (Necesario para el menú y los alerts) --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>