@extends('layouts.app')

@section('content')
<h2>Asistencia - {{ $fechaHoy }}</h2>

@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="admin-card"> {{-- Usamos admin-card para el contenedor --}}
    
    <form method="POST" action="{{ route('asistencias.store') }}">
        @csrf

        <input type="hidden" name="fecha" value="{{ $fechaHoy }}">

        <table class="data-table"> {{-- Usamos data-table de admin.css --}}
            <thead>
                <tr>
                    <th class="text-center">Asistió</th>
                    <th>Foto</th>
                    <th>Alumno</th>
                    <th>Categoría</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($alumnos as $alumno)
                <tr>
                    <td class="text-center">
                        {{-- El checkbox de HTML simple no usa clases de Bootstrap --}}
                        <input type="checkbox"
                                name="alumnos[{{ $alumno->id }}]"
                                style="transform: scale(1.3);" {{-- Estilo simple para hacerlo más visible --}}
                                {{ $alumno->asistencias->count() ? 'checked disabled' : '' }}>
                    </td>
                    
                    <td>
                        {{-- Lógica para la Foto --}}
                        @if ($alumno->foto)
                            <img src="{{ asset('storage/' . $alumno->foto) }}"
                                 alt="{{ $alumno->nombre }}"
                                 class="rounded-circle-foto"> {{-- Clase de admin.css --}}
                        @else
                            <i class="fas fa-user-circle fa-2x text-muted"></i>
                        @endif
                    </td>
                    
                    <td>{{ $alumno->nombre }} {{ $alumno->apellido }}</td>
                    <td>{{ $alumno->categoria->nombre }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4 pt-3 border-top">
            {{-- Usamos la clase personalizada para el botón principal --}}
            <button class="btn-primary-custom" type="submit">
                <i class="fas fa-save"></i> Guardar asistencia
            </button>
        </div>
    </form>
</div>
@endsection