@extends('layouts.app')

@section('content')
<h2>Cartilla de Asistencia</h2>

{{-- Tarjeta de información del alumno (usando admin-card) --}}
<div class="admin-card mb-4 info-alumno-cartilla"> 
    <div class="info-body">
        
        {{-- Foto del alumno (Si está disponible) --}}
        @if ($alumno->foto)
            <img src="{{ asset('storage/' . $alumno->foto) }}"
                 alt="{{ $alumno->nombre }}"
                 class="rounded-circle-foto me-3"> 
        @else
            <i class="fas fa-user-circle fa-3x text-muted me-3"></i>
        @endif
        
        <div class="details">
            <h5 class="nombre-alumno-cartilla">{{ $alumno->nombre }} {{ $alumno->apellido }}</h5>
            <p class="mb-1"><strong>Categoría:</strong> {{ $alumno->categoria->nombre }}</p>
            <p class="mb-0"><strong>Total asistencias:</strong> <span class="badge-total">{{ $asistencias->count() }}</span></p>
        </div>
    </div>
</div>

<div class="admin-card"> {{-- La tabla también va dentro de admin-card --}}
    <table class="data-table"> {{-- Usamos data-table de admin.css --}}
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($asistencias as $asistencia)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/m/Y') }}</td>
                    <td>
                        @if ($asistencia->presente)
                            {{-- Usamos las clases definidas en admin.css para los badges --}}
                            <span class="badge-pago pago-aldia">Asistió</span>
                        @else
                            <span class="badge-pago pago-deuda">Falta</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="text-center">Sin asistencias registradas</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{-- Usamos la clase personalizada para el botón secundario --}}
    <a href="{{ route('alumnos.index') }}" class="btn-secondary-custom">
        <i class="fas fa-arrow-circle-left"></i> Volver a Alumnos
    </a>
</div>
@endsection