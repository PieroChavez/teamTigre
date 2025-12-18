@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Pagos Registrados para: {{ $evento->nombre }}</h2>
        {{-- Botón para volver a la lista de eventos --}}
        <a href="{{ route('eventos.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver a Eventos
        </a>
    </div>

    @if ($pagos->isEmpty())
        <div class="alert alert-info">
            No se han encontrado pagos asociados a los alumnos inscritos en este evento.
        </div>
    @else
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-striped table-bordered align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Alumno</th>
                            <th>Fecha de Pago</th>
                            <th>Monto</th>
                            <th>Concepto</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pagos as $pago)
                            <tr>
                                <td>{{ $pago->alumno->nombre_completo ?? 'Alumno Eliminado' }}</td>
                                <td>{{ $pago->fecha_pago->format('Y-m-d') }}</td>
                                <td>S/ {{ number_format($pago->monto, 2) }}</td>
                                <td>{{ $pago->concepto }}</td>
                                <td>
                                    <span class="badge bg-{{ $pago->estado === 'anulado' ? 'danger' : 'success' }}">
                                        {{ ucfirst($pago->estado) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection