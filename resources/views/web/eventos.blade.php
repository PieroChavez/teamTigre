@extends('layouts.app')

@section('content')
<h2 class="mb-4">Eventos</h2>

<div class="row">
@forelse ($eventos as $evento)
    <div class="col-md-4 mb-3">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">{{ $evento->nombre }}</h5>
                <p class="card-text">
                    {{-- CORRECCIÓN: Aplicamos el formateo de fecha (d/m/Y) --}}
                    <strong>Fecha:</strong> {{ $evento->fecha?->format('d/m/Y') }}
                </p>

                <a href="{{ route('web.evento', $evento) }}"
                   class="btn btn-primary btn-sm">
                    Ver evento
                </a>
            </div>
        </div>
    </div>
@empty
    <p>No hay eventos disponibles.</p>
@endforelse
</div>
@endsection