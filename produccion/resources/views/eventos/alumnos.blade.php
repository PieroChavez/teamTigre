@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-4 align-items-center">
    <h3><i class="fas fa-user-plus me-2"></i> Inscribir Alumnos</h3>
    <a href="{{ route('eventos.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver a Eventos
    </a>
</div>

{{-- Mostramos el nombre del evento de forma resaltada --}}
<p class="lead"><strong>Evento:</strong> {{ $evento->nombre }}</p>

<form method="POST" action="{{ route('eventos.alumnos.store', $evento) }}">
    @csrf

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-dark text-white">
            Lista de Alumnos Disponibles
        </div>
        <div class="card-body p-0">

            {{-- Usamos table-hover para interactividad --}}
            <table class="table table-hover table-striped align-middle mb-0">
                <thead>
                    <tr class="table-light">
                        <th style="width: 10%">Seleccionar</th>
                        <th>Alumno</th>
                        <th>Categoría</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($alumnos as $alumno)
                    <tr>
                        <td class="text-center">
                            {{-- Checkbox --}}
                            <input type="checkbox" name="alumnos[]"
                                   value="{{ $alumno->id }}"
                                   {{ $evento->alumnos->contains($alumno->id) ? 'checked' : '' }}>
                        </td>
                        <td>{{ $alumno->nombre }} {{ $alumno->apellido }}</td>
                        <td>
                            <span class="badge bg-info text-dark">{{ $alumno->categoria->nombre }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted">No hay alumnos disponibles para inscribir.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    {{-- Botones de acción --}}
    <div class="d-flex justify-content-end gap-2">
        <button type="submit" class="btn btn-success">
            <i class="fas fa-save"></i> Guardar Inscripción
        </button>
    </div>
</form>
@endsection