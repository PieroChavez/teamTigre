<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | El Tigre Box - @yield('page_title', 'Dashboard')</title>

    {{-- Bootstrap CDN (opcional, si aún lo necesitas en el admin) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    {{-- CSS PRINCIPAL DEL ADMIN (donde está admin.css) --}}
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    
    {{-- Font Awesome para los íconos del Sidebar --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    @yield('styles')
</head>
<body>

{{-- ESTRUCTURA COMPLETA DEL DASHBOARD --}}
<div class="app-wrapper">
    
    {{-- BARRA LATERAL (SIDEBAR) - OCUPA TODA LA ALTURA --}}
    <aside class="sidebar">
        <div class="logo-admin">TIGRE BOX</div>
        
        <nav>
            <ul>
                {{-- Dashboard --}}
                <li><a href="{{ route('admin.dashboard') }}" class="{{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i> <span class="d-none d-md-inline">Dashboard</span>
                </a></li>
                
                {{-- Alumnos --}}
                <li><a href="{{ route('admin.alumnos.index') }}" class="{{ Request::routeIs('admin.alumnos.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> <span class="d-none d-md-inline">Alumnos</span>
                </a></li>

                {{-- Asistencias (Usando tu ruta existente como ejemplo) --}}
                <li><a href="{{ route('admin.asistencias.index') }}" class="{{ Request::routeIs('admin.asistencias.*') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-check"></i> <span class="d-none d-md-inline">Asistencia</span>
                </a></li>
                
                {{-- Eventos --}}
                <li><a href="{{ route('admin.eventos.index') }}" class="{{ Request::routeIs('admin.eventos.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt"></i> <span class="d-none d-md-inline">Eventos</span>
                </a></li>
                
                <hr style="border-color: rgba(255, 255, 255, 0.1); margin: 20px 10px;">

                {{-- Logout --}}
                <li>
                    {{-- IMPORTANTE: Debes tener una ruta 'logout' y el formulario en el HTML --}}
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> <span class="d-none d-md-inline">Cerrar Sesión</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    {{-- CONTENIDO PRINCIPAL Y HEADER --}}
    <main class="main-content">
        
        {{-- HEADER DEL CONTENIDO (Para el título de la página y el usuario) --}}
        <header class="admin-header">
            <h1>@yield('page_title', 'Gestión')</h1>
            <div class="user-info">
                {{-- Aquí iría la lógica de Auth (Auth::user()->name) una vez implementado el login --}}
                Bienvenido, Administrador
            </div>
        </header>

        {{-- Alertas de Sesión --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        {{-- CONTENIDO DE LA VISTA HIJA --}}
        @yield('content')
    </main>
</div>

{{-- Formulario oculto para el Logout (requerido para el POST) --}}
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

@yield('scripts')

{{-- Bootstrap JS (si se necesita) --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>