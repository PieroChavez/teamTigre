<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Escuela de Box El Tigre') }}</title>

    {{-- Fuentes --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

    {{-- Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Partículas --}}
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
</head>

<body class="min-h-screen bg-black text-white overflow-hidden">

    {{-- Fondo de partículas --}}
    <div id="particles-js" class="fixed inset-0 z-0"></div>

    {{-- Contenedor central --}}
    <div class="relative z-10 min-h-screen flex items-center justify-center px-4">
        <div
            class="w-full max-w-md
                   bg-gray-900/90
                   backdrop-blur-lg
                   p-8
                   rounded-2xl
                   border border-gray-800
                   shadow-[0_0_40px_rgba(249,115,22,0.25)]"
        >
            {{ $slot }}
        </div>
    </div>

    {{-- Configuración partículas --}}
    <script>
        particlesJS("particles-js", {
            particles: {
                number: {
                    value: 90,
                    density: { enable: true, value_area: 800 }
                },
                color: {
                    value: ["#ffffff", "#f97316"]
                },
                shape: { type: "circle" },
                opacity: {
                    value: 0.6,
                    random: true
                },
                size: {
                    value: 3,
                    random: true
                },
                line_linked: {
                    enable: true,
                    distance: 150,
                    color: "#f97316",
                    opacity: 0.25,
                    width: 1
                },
                move: {
                    enable: true,
                    speed: 1,
                    out_mode: "out"
                }
            },
            interactivity: {
                events: {
                    onhover: { enable: true, mode: "repulse" },
                    resize: true
                }
            },
            retina_detect: true
        });
    </script>

</body>
</html>
