@extends('layouts.app')

@section('content')
<h2>Nueva Noticia</h2>

<form method="POST" action="{{ route('noticias.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label class="form-label">Título</label>
        <input type="text" name="titulo" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Contenido</label>
        <textarea name="contenido" class="form-control" rows="5" required></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Imagen (opcional)</label>
        <input type="file" name="imagen" class="form-control">
    </div>

    <button class="btn btn-success">Publicar</button>
    <a href="{{ route('noticias.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
