@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h2>Noticias</h2>
    
    {{-- Usamos la clase 'btn-primary' de Bootstrap --}}
    <a href="{{ route('noticias.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> &nbsp; + Nueva Noticia
    </a>
</div>

@if ($noticias->count())
<div class="card"> {{-- Usamos la clase 'card' para agrupar el contenido --}}
    <div class="card-body p-0">
        {{-- Usamos clases estándar de tabla con estilos básicos --}}
        <table class="table table-bordered table-striped align-middle mb-0">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Fecha de Creación</th>
                    <th style="width: 120px" class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($noticias as $noticia)
                <tr>
                    {{-- Enlace para ver/editar la noticia --}}
                    <td>
                        <a href="#" class="text-decoration-none">
                            {{ $noticia->titulo }}
                        </a>
                    </td>
                    {{-- Aseguramos el uso de Carbon para el formato --}}
                    <td>{{ $noticia->created_at->format('d/m/Y') }}</td>
                    
                    <td class="d-flex gap-1 justify-content-center">
                        {{-- Ejemplo de botón para Editar (asumiendo que tendrás la ruta noticias.edit) --}}
                        <a href="#" class="btn btn-sm btn-warning" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        {{-- Ejemplo de botón para Eliminar --}}
                        <button class="btn btn-sm btn-danger" title="Eliminar">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@else
<div class="alert alert-info">
    <i class="fas fa-info-circle"></i> No hay noticias publicadas.
</div>
@endif
@endsection