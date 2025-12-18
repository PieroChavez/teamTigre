@extends('layouts.app')

@section('content')
<h2>{{ $evento->nombre }}</h2>

{{-- CORRECCIÓN: Aplicamos el formateo de fecha (d/m/Y) --}}
<p><strong>Fecha:</strong> {{ $evento->fecha?->format('d/m/Y') }}</p>

@if ($evento->descripcion)
    <p>{{ $evento->descripcion }}</p>
@endif

<hr>

<h4>Alumnos inscritos</h4>

@if ($evento->alumnos->count())
<ul>
@foreach ($evento->alumnos as $alumno)
    <li>
        {{ $alumno->nombre }} {{ $alumno->apellido }}
        - {{ $alumno->categoria->nombre }}
    </li>
@endforeach
</ul>
@else
<p>No hay alumnos inscritos</p>
@endif

<a href="{{ route('web.eventos') }}" class="btn btn-secondary mt-3">
    Volver a eventos
</a>
@endsection