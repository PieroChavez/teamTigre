<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club de Box "El Tigre"</title>

    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">
    {{-- Opcional: Si usas Bootstrap, asegúrate de incluir el CSS aquí --}}
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body>

<header id="navbar"
        class="fixed top-0 left-0 w-full z-50 transition-colors duration-300 bg-black">
    <nav class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">

            <button id="openMenu" class="lg:hidden p-1 text-white">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                </svg>
            </button>

               

            <!-- LOGO -->
            <a href="{{ route('web.home') }}" class="flex items-center">
                <img src="{{ asset('img/logo.png') }}" alt="El Tigre" class="h-11 w-auto">
            </a>

            <!-- MENÚ IZQUIERDA (SOLO PC) -->
            <div class="hidden lg:flex lg:space-x-8 mr-auto lg:ml-12">

    <!-- WOMEN -->
    <div class="group relative">
        <button class="text-sm font-medium text-white hover:text-orange-500">
            Mujeres
        </button>

        <div class="absolute left-0 top-full z-50 hidden w-screen max-w-md bg-white shadow-xl group-hover:block">
            <div class="grid grid-cols-2 gap-4 p-6">
                <img src="{{ asset('img/women1.jpg') }}" class="rounded-lg">
                <img src="{{ asset('img/women2.jpg') }}" class="rounded-lg">
            </div>
            <div class="px-6 pb-4">
                <a href="#" class="block py-1 text-sm text-gray-700">Ropa</a>
                <a href="#" class="block py-1 text-sm text-gray-700">Accesorios</a>
                <a href="#" class="block py-1 text-sm text-gray-700">Entrenamiento</a>
            </div>
        </div>
    </div>

    <!-- MEN -->
    <div class="group relative">
        <button class="text-sm font-medium text-white hover:text-orange-500">
            Hombres
        </button>

        <div class="absolute left-0 top-full z-50 hidden w-screen max-w-md bg-white shadow-xl group-hover:block">
            <div class="grid grid-cols-2 gap-4 p-6">
                <img src="{{ asset('img/men1.jpg') }}" class="rounded-lg">
                <img src="{{ asset('img/men2.jpg') }}" class="rounded-lg">
            </div>
            <div class="px-6 pb-4">
                <a href="#" class="block py-1 text-sm text-gray-700">Guantes</a>
                <a href="#" class="block py-1 text-sm text-gray-700">Protección</a>
                <a href="#" class="block py-1 text-sm text-gray-700">Ropa deportiva</a>
            </div>
        </div>
    </div>

</div>


            <!-- ICONOS DERECHA -->
            <div class="hidden lg:flex items-center space-x-6">

                <!-- SEARCH -->
                <button class="text-gray-400 hover:text-gray-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                    </svg>
                </button>

                <!-- CART -->
                <a href="#" class="relative text-gray-400 hover:text-gray-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007Z"/>
                    </svg>

                    <!-- CONTADOR -->
                    <span class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-indigo-600 text-xs text-white">
                        0
                    </span>
                </a>

                <!-- LOGIN -->
                <a href="{{ route('login') }}" class="text-sm font-medium text-white">
                    Iniciar sesión
                </a>
            </div>

        </div>
    </nav>

    <!-- MENÚ MÓVIL -->
    <div id="mobileMenu" class="fixed inset-0 z-50 hidden bg-black/30">
        <div class="h-full w-80 bg-white p-6">

            <button id="closeMenu" class="mb-6 text-gray-500">✕</button>

            <div class="space-y-6">
                <div>
                    <p class="font-semibold">Mujeres</p>
                    <ul class="mt-2 space-y-2 text-gray-600">
                        <li>Ropa</li>
                        <li>Accesorios</li>
                        <li>Entrenamiento</li>
                    </ul>
                </div>

                <div>
                    <p class="font-semibold">Hombres</p>
                    <ul class="mt-2 space-y-2 text-gray-600">
                        <li>Guantes</li>
                        <li>Protección</li>
                        <li>Ropa deportiva</li>
                    </ul>
                </div>

                

                <hr>

                <a href="{{ route('login') }}" class="block font-medium">Iniciar sesión</a>
            </div>
        </div>
    </div>
</header>
<!-- ESPACIO PARA NAVBAR FIJO <div class="h-16"></div> -->



<main>
    @yield('content')
</main>

{{-- Opcional: Si usas Bootstrap, incluye el JS antes del script final --}}
{{-- <script src="ruta/a/bootstrap.bundle.min.js"></script> --}}

<script src="{{ asset('js/scripts.js') }}"></script>

<script>
   
</script>


</body>
</html>