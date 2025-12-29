{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', 'Escuela de Box El Tigre') }}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

    {{-- Tailwind / Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Particles.js --}}
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
</head>

<body class="min-h-screen bg-black text-white overflow-hidden">

    {{-- Fondo de partículas --}}
    <div id="particles-js" class="fixed inset-0 z-0"></div>

    {{-- Contenedor principal --}}
    <div class="relative z-10 min-h-screen flex items-center justify-center px-4">

        {{-- Caja Login (Glassmorphism) --}}
        <div class="w-full max-w-md
                    bg-white/8
                    backdrop-blur-2xl
                    p-8
                    rounded-2xl
                    shadow-2xl
                    border border-white/20
                    ring-1 ring-orange-500/20">

            {{-- Logo --}}
            <div class="flex justify-center mb-6">
                <img src="{{ asset('favicon.png') }}" alt="Logo" class="w-20 drop-shadow-lg">
            </div>

            {{-- Título --}}
            <h1 class="text-2xl font-bold text-center text-orange-500 mb-6">
                Acceso Clientes
            </h1>

            {{-- Estado sesión --}}
            <x-auth-session-status class="mb-4 text-orange-400" :status="session('status')" />

            {{-- Formulario --}}
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                {{-- Email --}}
                <div>
                    <label class="block text-sm mb-1 text-gray-300">Email</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="w-full rounded-lg bg-black/40 border border-gray-600
                               text-white px-4 py-2
                               focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-sm mb-1 text-gray-300">Contraseña</label>
                    <input
                        type="password"
                        name="password"
                        required
                        class="w-full rounded-lg bg-black/40 border border-gray-600
                               text-white px-4 py-2
                               focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                {{-- Remember --}}
                <div class="flex items-center">
                    <input
                        type="checkbox"
                        name="remember"
                        class="rounded bg-black/40 border-gray-600 text-orange-500 focus:ring-orange-500">
                    <span class="ml-2 text-sm text-gray-400">Recordarme</span>
                </div>

                {{-- Botón --}}
                <button
                    type="submit"
                    class="w-full bg-orange-600 hover:bg-orange-700
                           transition font-semibold py-2 rounded-lg
                           shadow-lg shadow-orange-500/30">
                    Ingresar
                </button>

                {{-- Olvidé contraseña --}}
                @if (Route::has('password.request'))
                    <div class="text-center mt-4">
                        <a href="{{ route('password.request') }}"
                           class="text-sm text-gray-400 hover:text-orange-400 transition">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    {{-- Configuración de partículas --}}
    <script>
        particlesJS("particles-js", {
            particles: {
                number: { value: 80 },
                color: { value: ["#ffffff", "#f97316"] },
                shape: { type: "circle" },
                opacity: { value: 0.6 },
                size: { value: 3 },
                move: { enable: true, speed: 1.3 },
                line_linked: {
                    enable: true,
                    distance: 140,
                    color: "#f97316",
                    opacity: 0.3,
                    width: 1
                }
            },
            retina_detect: true
        });
    </script>

</body>
</html>
