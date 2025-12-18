<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club de Box "El Tigre"</title>
 
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">
</head>
<body>

<nav class="menu">
    <div class="logo">El Tigre</div>
    <ul class="nav-links">
        <li><a href="{{ route('web.home') }}">Inicio</a></li>
        <li><a href="{{ route('web.informacion') }}">Información</a></li>
        <li><a href="{{ route('web.login') }}" class="btn-login">Login</a></li>
    </ul>
</nav>

<main>
    @yield('content')
</main>


<script src="{{ asset('js/scripts.js') }}"></script>
</body>
</html>
