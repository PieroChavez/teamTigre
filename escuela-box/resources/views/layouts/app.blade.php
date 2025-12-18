<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Escuela de Box</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    {{-- Font Awesome (Necesario para los íconos) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    {{-- AÑADE ESTA LÍNEA para cargar tus estilos personalizados --}}
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        
        {{-- MODIFICACIÓN AQUÍ: Navbar Brand con Logo --}}
        <a class="navbar-brand d-flex align-items-center" href="/">
            <img src="{{ asset('img/logo.png') }}" 
                 alt="Logo Escuela de Box" 
                 style="height: 30px; margin-right: 8px;"
                 class="d-inline-block align-text-top">
            Escuela de Box
        </a>
        {{-- FIN DE MODIFICACIÓN --}}

        <div class="d-flex gap-2">
            <a class="btn btn-outline-light"
                href="{{ route('alumnos.index') }}">
               <i class="fas fa-users"></i> Alumnos
            </a>

            <a class="btn btn-outline-light"
                href="{{ route('asistencias.index') }}">
               <i class="fas fa-calendar-check"></i> Asistencia
            </a>
            
            {{-- NUEVO ENLACE: EVENTOS --}}
            <a class="btn btn-outline-light"
                href="{{ route('eventos.index') }}">
               <i class="fas fa-calendar-alt"></i> Eventos
            </a>
            
            {{-- NUEVO ENLACE: NOTICIAS --}}
            <a class="btn btn-outline-light"
                href="{{ route('noticias.index') }}">
               <i class="fas fa-newspaper"></i> Noticias
            </a>
            
            {{-- Aquí iría el enlace a Historial de Pagos si decides mantenerlo --}}
            
        </div>
    </div>
</nav>

<div class="container mt-4">

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @yield('content')

</div>

</body>
</html>