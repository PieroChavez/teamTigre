@extends('layouts.web')

@section('content')
<!-- Sección de Bienvenida / Portada -->
<section class="bienvenida">
    <div class="overlay">
        <div class="contenido text-center">
            <h1>Bienvenido al Club de Box "El Tigre"</h1>
            <p>Aprende, entrena y forma parte de nuestra comunidad.</p>
            <a href="{{ route('web.informacion') }}" class="btn btn-info">Más Información</a>
            <a href="{{ route('web.login') }}" class="btn btn-success">Login</a>
        </div>
    </div>
</section>

<!-- Próximos Eventos -->
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

<!-- Últimas Noticias -->
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

<!-- Llamado a la acción -->
<section class="cta text-center">
    <div class="container">
        <h2>Únete a Nuestra Comunidad</h2>
        <p>Inscríbete ahora y participa en nuestros cursos y eventos.</p>
        <a href="{{ route('web.login') }}" class="btn btn-success btn-lg">Login / Inscripción</a>
    </div>
</section>
@endsection
