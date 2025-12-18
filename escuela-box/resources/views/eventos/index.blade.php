@extends('layouts.app') 

@section('content')
<div class="d-flex justify-content-between mb-4 align-items-center">
    {{-- Agregamos un ícono al título --}}
    <h2><i class="fas fa-calendar-alt me-2"></i> Eventos Registrados</h2>
    
    <a href="{{ route('eventos.create') }}" class="btn btn-primary">
        <i class="fas fa-calendar-plus"></i> &nbsp; + Nuevo Evento
    </a>
</div>

@if ($eventos->count())
<div class="card shadow-sm"> {{-- Añadimos una sombra sutil a la tarjeta --}}
    <div class="card-body p-0">
        <table class="table table-hover table-striped align-middle mb-0"> {{-- Usamos table-hover para interactividad --}}
            <thead class="table-dark"> {{-- Encabezado oscuro para mejor contraste --}}
                <tr>
                    <th>Nombre</th>
                    <th>Fecha</th>
                    <th>Costo</th> {{-- Eliminamos (S/) del encabezado ya que se ve en la columna --}}
                    <th class="text-center">Inscritos</th>
                    <th style="width: 250px" class="text-center">Acciones</th> {{-- Aumenté el ancho para 4 botones --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($eventos as $evento)
                <tr>
                    <td>{{ $evento->nombre }}</td>
                    
                    {{-- Formato Y-m-d para consistencia con BD, pero podrías usar d/m/Y --}}
                    <td>{{ $evento->fecha?->format('Y-m-d') }}</td>
                    
                    <td>
                        {{-- Usamos un badge para resaltar el costo --}}
                        <span class="badge bg-success">S/ {{ number_format($evento->costo ?? 0, 2) }}</span>
                    </td>
                    
                    <td class="text-center">
                        <span class="badge bg-secondary rounded-pill">{{ $evento->alumnos->count() ?? 0 }}</span>
                    </td>
                    
                    <td class="d-flex gap-1 justify-content-center">
                        
                        <a href="{{ route('eventos.inscribir', $evento->id) }}"
                           class="btn btn-sm btn-info" title="Inscribir Alumno">
                           <i class="fas fa-user-plus"></i>
                        </a>

                        <a href="{{ route('eventos.alumnos', $evento->id) }}"
                           class="btn btn-sm btn-secondary" title="Ver Alumnos Inscritos">
                            <i class="fas fa-user-check"></i>
                        </a>
                        
                        {{-- Botón de Editar (Asumiendo que implementarás la ruta 'eventos.edit') --}}
                        <a href="#" 
                           class="btn btn-sm btn-warning" title="Editar Evento">
                           <i class="fas fa-edit"></i>
                        </a>
                        
                        {{-- Botón de Eliminar (Asumiendo que implementarás la ruta 'eventos.destroy') --}}
                        <button type="button" class="btn btn-sm btn-danger" title="Eliminar Evento">
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
    <i class="fas fa-info-circle"></i> No hay eventos registrados.
</div>
@endif
@endsection