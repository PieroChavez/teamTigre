<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club de Box "El Tigre"</title>

    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">
    {{-- Opcional: Si usas Bootstrap, asegúrate de incluir el CSS aquí --}}
</head>
<body>

<nav class="menu">
    <div class="logo">Club de Box "El Tigre" </div>
    <ul class="nav-links">
        <li><a href="{{ route('web.home') }}">Inicio</a></li>
        <li><a href="{{ route('web.informacion') }}">Información</a></li>
        
        {{-- 🛑 CORRECCIÓN: Cambiado de 'web.login' a 'login' 🛑 --}}
        <li><a href="{{ route('login') }}" class="btn-login">Login</a></li>
    </ul>
</nav>

<main>
    @yield('content')
</main>

{{-- Opcional: Si usas Bootstrap, incluye el JS antes del script final --}}
{{-- <script src="ruta/a/bootstrap.bundle.min.js"></script> --}}

<script src="{{ asset('js/scripts.js') }}"></script>
</body>
</html>