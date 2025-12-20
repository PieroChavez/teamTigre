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


<section class="eventos">
    <div class="container">
        <h2 class="text-center mb-4">Próximos Eventos</h2>
        <div class="grid-eventos">
            @foreach(App\Models\Evento::orderBy('fecha', 'asc')->take(3)->get() as $evento)
                <div class="evento-card">
                    <h3>{{ $evento->nombre }}</h3>
                    <p>{{ \Illuminate\Support\Str::limit($evento->descripcion, 80) }}</p>
                    <p class="fecha">{{ \Carbon\Carbon::parse($evento->fecha)->format('d M, Y') }}</p>
                    <a href="{{ route('web.evento', $evento->id) }}" class="btn btn-primary">Ver Evento</a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="noticias bg-light">
    <div class="container">
        <h2 class="text-center mb-4">Últimas Noticias</h2>
        <div class="grid-noticias">
            @foreach(App\Models\Noticia::orderBy('created_at', 'desc')->take(3)->get() as $noticia)
                <div class="noticia-card">
                    <h3>{{ $noticia->titulo }}</h3>
                    <p>{{ \Illuminate\Support\Str::limit($noticia->contenido, 80) }}</p>
                    <p class="fecha">{{ $noticia->created_at->format('d M, Y') }}</p>
                    <a href="{{ route('web.noticia', $noticia->id) }}" class="btn btn-secondary">Leer Más</a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="cta text-center">
    <div class="container">
        <h2>Únete a Nuestra Comunidad</h2>
        <p>Inscríbete ahora y participa en nuestros cursos y eventos.</p>
        {{-- 🛑 CORRECCIÓN 2: Cambiado de 'web.login' a 'login' --}}
        <a href="{{ route('login') }}" class="btn btn-success btn-lg">Login / Inscripción</a>
    </div>
</section>
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