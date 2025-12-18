@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-4 align-items-center">
    <h2><i class="fas fa-user-plus me-2"></i> Inscribir Alumnos</h2>
    <a href="{{ route('eventos.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver a Eventos
    </a>
</div>

<p class="lead">Inscribir alumnos en: <strong>{{ $evento->nombre }}</strong></p>

<form method="POST" action="{{ route('eventos.inscribir.guardar', $evento->id) }}">
    @csrf
    
    <div class="card shadow-sm mb-4">
        <div class="card-body p-0">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 5%">#</th> {{-- Columna para el Checkbox --}}
                        <th>Nombre Completo</th>
                        <th>Categoría</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($alumnos as $alumno)
                    <tr>
                        <td class="text-center">
                            {{-- Checkbox --}}
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="alumnos[]"
                                       value="{{ $alumno->id }}"
                                       {{ $evento->alumnos->contains($alumno->id) ? 'checked' : '' }}>
                            </div>
                        </td>
                        <td>
                            <label class="form-check-label w-100">
                                {{ $alumno->nombre }} {{ $alumno->apellido }}
                            </label>
                        </td>
                        <td>
                             {{-- Asumiendo que el modelo Alumno tiene relación con Categoria --}}
                            <span class="badge bg-info text-dark">
                                {{ $alumno->categoria->nombre ?? 'Sin Categoría' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">
                            No hay alumnos disponibles para inscribir.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-success">
            <i class="fas fa-save"></i> Guardar inscripción
        </button>
    </div>
</form>
@endsection