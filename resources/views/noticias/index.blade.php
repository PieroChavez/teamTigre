@extends('layouts.app')

{{-- Asegúrate de añadir el @section('title') para que el layout lo use --}}
@section('title', 'Administración de Noticias') 

@section('content')

{{-- Mensajes de éxito/error de la sesión --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="d-flex justify-content-between mb-3">
    <h2 class="text-primary"><i class="fas fa-newspaper me-2"></i> Noticias Publicadas</h2>
    
    {{-- Botón para crear nueva noticia --}}
    <a href="{{ route('noticias.create') }}" class="btn btn-success btn-lg">
        <i class="fas fa-plus"></i> &nbsp; + Nueva Noticia
    </a>
</div>

@if ($noticias->count())
<div class="card shadow">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="bg-dark text-white">
                    <tr>
                        <th style="width: 5%">ID</th>
                        <th>Título</th>
                        <th style="width: 15%">Fecha de Creación</th>
                        <th style="width: 120px" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($noticias as $noticia)
                    <tr>
                        <td>{{ $noticia->id }}</td>
                        
                        {{-- ENLACE CORREGIDO: Apunta a la vista de detalle (show) --}}
                        <td>
                            <a href="{{ route('noticias.show', $noticia) }}" class="text-decoration-none fw-bold">
                                {{ $noticia->titulo }}
                            </a>
                        </td>
                        
                        <td>{{ $noticia->created_at->format('d/m/Y') }}</td>
                        
                        <td class="d-flex gap-1 justify-content-center">
                            
                            {{-- Botón VER (Usamos show) --}}
                            <a href="{{ route('noticias.show', $noticia) }}" class="btn btn-sm btn-info" title="Ver Detalle">
                                <i class="fas fa-eye"></i>
                            </a>
                            
                            {{-- Botón EDITAR (Usamos edit) --}}
                            <a href="{{ route('noticias.edit', $noticia) }}" class="btn btn-sm btn-warning" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            {{-- FORMULARIO ELIMINAR (Usamos destroy) --}}
                            <form action="{{ route('noticias.destroy', $noticia) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro de que desea eliminar la noticia: {{ $noticia->titulo }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        {{-- Paginación básica (si usaste paginate() en el controlador) --}}
        {{-- <div class="card-footer">
            {{ $noticias->links() }}
        </div> --}}
        
    </div>
</div>
@else
<div class="alert alert-info shadow">
    <i class="fas fa-info-circle me-1"></i> No hay noticias publicadas. Utiliza el botón "+ Nueva Noticia" para empezar a crear contenido.
</div>
@endif
@endsection