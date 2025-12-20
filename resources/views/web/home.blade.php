@extends('layouts.web')

@section('content')

<!-- CAROUSEL TEXTO PROMOCIONES -->
<!-- BARRA PROMOCIONAL -->
<div class="relative w-full overflow-hidden "> <!-- border-b border-gray-800 bg-black text-white   BARRA PROMOCIONAL -->

    <!-- CONTENEDOR DEL CARRUSEL -->
    <div id="textCarousel"
         class="flex transition-transform duration-700 ease-in-out">

        <!-- SLIDE 1 -->
        <div class="min-w-full px-4 py-3 sm:py-4 text-center">
            <h2 class="text-sm sm:text-base font-semibold text-orange-500 uppercase">
                🔥 Promo de Bienvenida
            </h2>
            <p class="text-sm sm:text-base">
                Inscríbete hoy y obtén <strong>20% de descuento</strong>
            </p>
        </div>

        <!-- SLIDE 2 -->
        <div class="min-w-full px-4 py-3 sm:py-4 text-center">
            <h2 class="text-sm sm:text-base font-semibold text-orange-500 uppercase">
                🥊 Clases Ilimitadas
            </h2>
            <p class="text-sm sm:text-base">
                Entrena sin límites por solo <strong>S/ 99 al mes</strong>
            </p>
        </div>

        <!-- SLIDE 3 -->
        <div class="min-w-full px-4 py-3 sm:py-4 text-center">
            <h2 class="text-sm sm:text-base font-semibold text-orange-500 uppercase">
                💪 Plan Familiar
            </h2>
            <p class="text-sm sm:text-base">
                Inscríbete con alguien más y obtén <strong>30% OFF</strong>
            </p>
        </div>

    </div>

    <!-- BOTÓN PREV -->
    <button onclick="prevTextSlide()"
            class="absolute left-2 top-1/2 -translate-y-1/2 text-white text-xl hover:text-orange-500">
        ❮
    </button>

    <!-- BOTÓN NEXT -->
    <button onclick="nextTextSlide()"
            class="absolute right-2 top-1/2 -translate-y-1/2 text-white text-xl hover:text-orange-500">
        ❯
    </button>

</div>

<section class="relative w-full">

    <!-- FONDO MÓVIL -->
    <div
        class="absolute inset-0 bg-cover bg-center sm:hidden min-h-[35vh]"
        style="background-image: url('{{ asset('img/portada_movile.png') }}');">
    </div>

    <!-- FONDO DESKTOP -->
    <div
        class="absolute inset-0 bg-cover bg-center hidden sm:block min-h-[65vh] lg:min-h-[70vh]"
        style="background-image: url('{{ asset('img/portada.png') }}');">
    </div>

    <!-- OVERLAY -->
    <div class="absolute inset-0 bg-black/30"></div>

    <!-- ALTURA REAL -->
    <div class="relative min-h-[35vh] sm:min-h-[65vh] lg:min-h-[70vh]"></div>

</section>




<!-- 
    <div class="relative z-10 flex items-center justify-center text-center text-white px-4 py-16">

        <div class="max-w-2xl">
            

            <p class="mt-4 text-base sm:text-lg">
                Inscríbete al <strong>Club de Box El Tigre</strong> y obtén
                <span class="text-orange-400 font-semibold">hasta 30% de descuento</span>
            </p>

            <a href="#"
               class="inline-block mt-6 bg-white text-black px-6 py-3 font-semibold rounded-full hover:bg-orange-500 hover:text-white transition">
                INSCRÍBETE AHORA
            </a>
        </div>

    </div>  -->




<!-- 
<section class="relative overflow-hidden bg-white">
    <div class="pt-10 pb-32 sm:pt-32 sm:pb-40 lg:pt-40 lg:pb-48">
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            
            {{-- TEXTO PRINCIPAL --}}
            <div class="sm:max-w-lg">
                <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-6xl">
                    Inicio de clases <span class="text-orange-500">"5 de enero"</span>
                </h1>

                <p class="mt-4 text-xl text-gray-600">
                    Entrena con disciplina, mejora tu técnica y forma parte de una comunidad
                    enfocada en el alto rendimiento y el respeto.
                </p>

                <div class="mt-8 flex gap-4">
                    <a href="{{ route('web.informacion') }}"
                       class="inline-block rounded-md bg-orange-500 px-8 py-3 font-medium text-white hover:bg-orange-600 transition">
                        Más información
                    </a>

                    <a href="{{ route('login') }}"
                       class="inline-block rounded-md border border-orange-500 px-8 py-3 font-medium text-orange-500 hover:bg-orange-50 transition">
                        Login
                    </a>
                </div>
            </div>

            {{-- IMÁGENES DECORATIVAS --}}
            <div aria-hidden="true"
                 class="pointer-events-none lg:absolute lg:inset-y-0 lg:mx-auto lg:w-full lg:max-w-7xl">
                <div
                    class="absolute transform sm:top-0 sm:left-1/2 sm:translate-x-8
                           lg:top-1/2 lg:left-1/2 lg:translate-x-8 lg:-translate-y-1/2">

                    <div class="flex items-center space-x-6 lg:space-x-8">

                        <div class="grid grid-cols-1 gap-y-6 lg:gap-y-8">
                            <img src="https://images.unsplash.com/photo-1599058917212-d750089bc07c"
                                 class="h-64 w-44 rounded-lg object-cover shadow-lg"
                                 alt="Entrenamiento de box">
                            <img src="https://images.unsplash.com/photo-1605296867304-46d5465a13f1"
                                 class="h-64 w-44 rounded-lg object-cover shadow-lg"
                                 alt="Boxeo profesional">
                        </div>

                        <div class="grid grid-cols-1 gap-y-6 lg:gap-y-8">
                            <img src="https://images.unsplash.com/photo-1571019613576-2b22c76fd955"
                                 class="h-64 w-44 rounded-lg object-cover shadow-lg"
                                 alt="Guantes de box">
                            <img src="https://images.unsplash.com/photo-1583454110551-21f2fa2afe61"
                                 class="h-64 w-44 rounded-lg object-cover shadow-lg"
                                 alt="Saco de box">
                        </div>

                        <div class="grid grid-cols-1 gap-y-6 lg:gap-y-8">
                            <img src="https://images.unsplash.com/photo-1546519638-68e109498ffc"
                                 class="h-64 w-44 rounded-lg object-cover shadow-lg"
                                 alt="Entrenamiento físico">
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
-->
<section class="py-20 bg-gray-100">
    <div class="max-w-7xl mx-auto px-4">

        <!-- TÍTULO -->
        <h2 class="text-center text-3xl font-bold mb-14">
            NO TE PUEDES PERDER
        </h2>

        <!-- GRID RESPONSIVE REAL -->
        <div
            class="grid
                   grid-cols-1
                   sm:grid-cols-2
                   lg:grid-cols-3
                   xl:grid-cols-4
                   gap-10
                   justify-items-center">

            @foreach(
                App\Models\Evento::orderBy('created_at', 'desc')->get()
                as $evento
            )
                <div
                    class="w-full max-w-sm
                           bg-white rounded-2xl shadow-md
                           hover:shadow-xl transition
                           overflow-hidden flex flex-col">

                    <!-- IMAGEN -->
                    <img
                        src="{{ asset('img/portada.png') }}"
                        alt="Evento {{ $evento->nombre }}"
                        class="h-44 w-full object-cover">

                    <!-- CONTENIDO -->
                    <div class="p-6 flex flex-col flex-grow text-center">

                        <h3 class="text-lg font-semibold mb-3">
                            {{ $evento->nombre }}
                        </h3>

                        <p class="text-gray-600 text-sm mb-4">
                            {{ \Illuminate\Support\Str::limit($evento->descripcion, 80) }}
                        </p>

                        <p class="text-sm text-gray-500 mb-6">
                            📅 {{ \Carbon\Carbon::parse($evento->fecha)->format('d M, Y') }}
                        </p>

                        <!-- BOTÓN -->
                        <a href="{{ route('web.evento', $evento->id) }}"
                           class="mt-auto inline-block w-full
                                  rounded-xl bg-orange-500
                                  py-3 text-white font-semibold
                                  hover:bg-orange-600 transition">
                            Ver Evento
                        </a>
                    </div>
                </div>
            @endforeach

        </div>

        <!-- BOTÓN GENERAL -->
        <div class="mt-16 text-center">
            <a href="{{ route('web.eventos') }}"
               class="inline-block rounded-xl border-2 border-orange-500
                      px-10 py-3 font-semibold text-orange-500
                      hover:bg-orange-500 hover:text-white transition">
                Ver todos los eventos
            </a>
        </div>

    </div>
</section>






<section class="py-20 bg-gray-100">
    <div class="max-w-7xl mx-auto px-4">

        <h2 class="text-3xl font-bold mb-10 uppercase">
            Destacado
        </h2>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

            <!-- NOTICIA DESTACADA -->
            @php
                $destacada = App\Models\Noticia::orderBy('created_at','desc')->first();
            @endphp

            @if($destacada)
            <div class="lg:col-span-2 bg-white rounded-xl shadow overflow-hidden">
                
                <!-- IMAGEN -->
                <img src="{{ asset('img/portada.png') }}"
                     class="w-full h-[420px] object-cover">

                <div class="p-6">
                    <span class="text-sm text-gray-500 uppercase">
                        Destacado
                    </span>

                    <h3 class="text-2xl font-bold mt-2 mb-4">
                        {{ $destacada->titulo }}
                    </h3>

                    <p class="text-gray-600 mb-6">
                        {{ \Illuminate\Support\Str::limit($destacada->contenido, 150) }}
                    </p>

                    <a href="{{ route('web.noticia', $destacada->id) }}"
                       class="inline-block font-semibold text-orange-500 hover:underline">
                        Leer más →
                    </a>
                </div>
            </div>
            @endif

            <!-- COLUMNA INSTAGRAM -->
            <div class="bg-white rounded-xl shadow p-4">
                <h4 class="font-semibold mb-4">Instagram</h4>

                <!-- EMBED -->
                <iframe
                    src="https://www.instagram.com/p/CODE_AQUI/embed"
                    class="w-full h-[500px]"
                    frameborder="0"
                    scrolling="no"
                    allowtransparency="true">
                </iframe>
            </div>

        </div>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4">

        <!-- TÍTULO -->
        <h2 class="text-3xl font-bold mb-12 uppercase">
            Últimas Noticias
        </h2>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

            <!-- GRID DE NOTICIAS -->
            <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-10">

                @foreach(
                    App\Models\Noticia::orderBy('created_at', 'desc')->get()
                    as $noticia
                )
                <article class="bg-white shadow rounded-xl overflow-hidden group">

                    <!-- IMAGEN -->
                    <div class="overflow-hidden">
                        <img
                            src="{{ asset('img/portada.png') }}"
                            alt="{{ $noticia->titulo }}"
                            class="w-full h-56 object-cover
                                   group-hover:scale-105 transition duration-300">
                    </div>

                    <!-- CONTENIDO -->
                    <div class="p-6">
                        <span class="text-xs text-gray-500 uppercase">
                            {{ $noticia->created_at->diffForHumans() }}
                        </span>

                        <h3 class="text-lg font-bold mt-2 mb-3 leading-snug">
                            {{ $noticia->titulo }}
                        </h3>

                        <a href="{{ route('web.noticia', $noticia->id) }}"
                           class="font-semibold text-orange-500 hover:underline">
                            Leer más →
                        </a>
                    </div>
                </article>
                @endforeach

            </div>

            <!-- COLUMNA INSTAGRAM -->
            <aside class="bg-gray-50 rounded-xl shadow p-4 h-fit sticky top-24">

                <h4 class="font-semibold mb-4">
                    Instagram
                </h4>

                <!-- EMBED INSTAGRAM -->
                <iframe
                    src="https://www.instagram.com/p/CODE_AQUI/embed"
                    class="w-full h-[520px] rounded"
                    frameborder="0"
                    scrolling="no"
                    allowtransparency="true">
                </iframe>

            </aside>

        </div>
    </div>
</section>


<footer class="bg-black text-gray-300 pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-6">

        <!-- GRID PRINCIPAL -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10">

            <!-- LOGO + DESCRIPCIÓN -->
            <div>
                <a href="{{ route('home') }}" class="inline-block mb-4">
                    <img src="{{ asset('img/logo.png') }}"
                         alt="Logo"
                         class="h-10">
                </a>

                <p class="text-sm leading-relaxed text-gray-400">
                    Entrenamos campeones. Comunidad dedicada al boxeo,
                    MMA y alto rendimiento deportivo.
                </p>
            </div>

            <!-- NAVEGACIÓN -->
            <div>
                <h4 class="text-white font-semibold mb-4">
                    Navegación
                </h4>
                <ul class="space-y-3 text-sm">
                    <li>
                        <a href="{{ route('home') }}" class="hover:text-orange-500 transition">
                            Inicio
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('web.eventos') }}" class="hover:text-orange-500 transition">
                            Eventos
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('web.noticias') }}" class="hover:text-orange-500 transition">
                            Noticias
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('login') }}" class="hover:text-orange-500 transition">
                            Login / Registro
                        </a>
                    </li>
                </ul>
            </div>

            <!-- CONTACTO -->
            <div>
                <h4 class="text-white font-semibold mb-4">
                    Contacto
                </h4>
                <ul class="space-y-3 text-sm text-gray-400">
                    <li>📍 Huancayo, Perú</li>
                    <li>📧 contacto@tusitio.com</li>
                    <li>📞 +51 999 999 999</li>
                </ul>
            </div>

            <!-- REDES SOCIALES -->
            <div>
                <h4 class="text-white font-semibold mb-4">
                    Síguenos
                </h4>

                <div class="flex space-x-4">
                    <a href="#"
                       class="w-10 h-10 flex items-center justify-center
                              rounded-full border border-gray-600
                              hover:bg-orange-500 hover:border-orange-500 transition">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                            <path d="M22 12a10 10 0 1 0-11.5 9.9v-7h-2v-3h2v-2c0-2 1.2-3 3-3h2v3h-2c-.6 0-1 .4-1 1v1h3l-.5 3h-2.5v7A10 10 0 0 0 22 12z"/>
                        </svg>
                    </a>

                    <a href="#"
                       class="w-10 h-10 flex items-center justify-center
                              rounded-full border border-gray-600
                              hover:bg-orange-500 hover:border-orange-500 transition">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                            <path d="M7 2C4.2 2 2 4.2 2 7v10c0 2.8 2.2 5 5 5h10c2.8 0 5-2.2 5-5V7c0-2.8-2.2-5-5-5H7zm10 2c1.7 0 3 1.3 3 3v10c0 1.7-1.3 3-3 3H7c-1.7 0-3-1.3-3-3V7c0-1.7 1.3-3 3-3h10zm-5 3a5 5 0 1 0 0 10 5 5 0 0 0 0-10zm0 2a3 3 0 1 1 0 6 3 3 0 0 1 0-6zm4.5-.9a1.1 1.1 0 1 0 0 2.2 1.1 1.1 0 0 0 0-2.2z"/>
                        </svg>
                    </a>
                </div>
            </div>

        </div>

        <!-- DIVIDER -->
        <div class="border-t border-gray-800 mt-12 pt-6 text-center text-sm text-gray-500">
            © {{ date('Y') }} Tu Marca. Todos los derechos reservados.
        </div>

    </div>
</footer>


<script>
    const textCarousel = document.getElementById('textCarousel');
    const textSlides = textCarousel.children;
    let textIndex = 0;

    function showTextSlide(i) {
        textIndex = (i + textSlides.length) % textSlides.length;
        textCarousel.style.transform = `translateX(-${textIndex * 100}%)`;
    }

    function nextTextSlide() {
        showTextSlide(textIndex + 1);
    }

    function prevTextSlide() {
        showTextSlide(textIndex - 1);
    }

    // AUTOPLAY
    setInterval(() => {
        nextTextSlide();
    }, 4000);
</script>

@endsection