<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Club de Box</title>
    
    {{-- Bootstrap y Font Awesome (Necesarios para los estilos del formulario) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    {{-- CSS Personalizado --}}
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}"> 
    {{-- 👆 Usaremos un archivo CSS nuevo, 'auth.css', para no mezclar con 'estilo.css' --}}
    
</head>
<body>
    
    {{-- Contenedor para las partículas (Debe ser el primer elemento del body y a full screen) --}}
    <div id="particles-js"></div> 

    {{-- Contenido principal de la página de Login --}}
    <div class="main-content">
        @yield('content')
    </div>

    {{-- Librería de Partículas --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/particles.js/2.0.0/particles.min.js"></script>
    
    {{-- Inicialización de las Partículas y JS para centrado --}}
    <script>
        // Inicialización de Particles.js (Configuración simple)
        particlesJS('particles-js', {
            "particles": {
                "number": {"value": 80, "density": {"enable": true, "value_area": 800}},
                "color": {"value": "#ffffff"},
                "shape": {"type": "circle", "stroke": {"width": 0, "color": "#000000"}},
                "opacity": {"value": 0.5, "random": false},
                "size": {"value": 3, "random": true},
                "line_linked": {"enable": true, "distance": 150, "color": "#ffffff", "opacity": 0.4, "width": 1},
                "move": {"enable": true, "speed": 6, "direction": "none", "random": false, "straight": false, "out_mode": "out"}
            },
            "interactivity": {
                "detect_on": "canvas",
                "events": {"onhover": {"enable": true, "mode": "grab"}, "onclick": {"enable": true, "mode": "push"}, "resize": true},
            },
            "retina_detect": true
        });
    </script>
</body>
</html>