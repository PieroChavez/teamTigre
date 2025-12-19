@extends('layouts.app')

@section('content')
<h2>Noticias</h2>

<div class="row">
@foreach ($noticias as $noticia)
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            @if ($noticia->imagen)
                <img src="{{ asset('storage/'.$noticia->imagen) }}" class="card-img-top">
            @endif
            <div class="card-body">
                <h5>{{ $noticia->titulo }}</h5>
                <a href="{{ route('web.noticia', $noticia) }}" class="btn btn-sm btn-primary">
                    Leer más
                </a>
            </div>
        </div>
    </div>
@endforeach
</div>

{{ $noticias->links() }}
@endsection
