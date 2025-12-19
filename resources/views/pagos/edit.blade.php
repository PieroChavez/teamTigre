@extends('layouts.app')

@section('content')
<h2>Editar Pago – {{ $pago->alumno->nombre }} {{ $pago->alumno->apellido }}</h2>

{{-- ------------------------------------------------------------- --}}
{{-- INFORMACIÓN DEL ALUMNO (Con Foto) --}}
{{-- ------------------------------------------------------------- --}}
<div class="admin-card mb-4 info-alumno-cartilla"> 
    <div class="info-body">
        
        @if ($pago->alumno->foto)
            <img src="{{ asset('storage/' . $pago->alumno->foto) }}"
                 alt="{{ $pago->alumno->nombre }}"
                 class="rounded-circle-foto me-3"> 
        @else
            <i class="fas fa-user-circle fa-3x text-muted me-3"></i>
        @endif
        
        <div class="details">
            <h5 class="nombre-alumno-cartilla">{{ $pago->alumno->nombre }} {{ $pago->alumno->apellido }}</h5>
            <p class="mb-1"><strong>Categoría:</strong> {{ $pago->alumno->categoria->nombre }}</p>
            <p class="mb-0"><strong>Estado del Pago a Editar:</strong> 
                @if ($pago->estado === 'activo')
                    <span class="badge-pago pago-aldia">Activo</span>
                @else
                    <span class="badge-pago pago-anulado">Anulado</span>
                @endif
            </p>
        </div>
    </div>
</div>
{{-- ------------------------------------------------------------- --}}

<div class="admin-card"> {{-- admin-card para contener la lógica y formulario --}}

    @if($pago->estado === 'anulado')
        <div class="alert alert-danger mb-0">
            <i class="fas fa-ban"></i> Este pago ha sido anulado y no se puede editar.
        </div>
        
        <div class="mt-3">
            <a href="{{ route('alumnos.pagos', $pago->alumno_id) }}" class="btn-secondary-custom">
                <i class="fas fa-arrow-circle-left"></i> Volver
            </a>
        </div>
    @else
        <form method="POST" action="{{ route('pagos.update', $pago->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group-custom mb-3">
                <label for="monto" class="form-label">Monto (S/)</label>
                <input type="number" name="monto" id="monto" step="0.01" min="0" 
                       class="form-input-custom" 
                       value="{{ old('monto', $pago->monto) }}" required>
            </div>

            <div class="form-group-custom mb-3">
                <label for="fecha_pago" class="form-label">Fecha</label>
                <input type="date" name="fecha_pago" id="fecha_pago" 
                       class="form-input-custom" 
                       value="{{ old('fecha_pago', $pago->fecha_pago->format('Y-m-d')) }}" required>
            </div>

            <div class="form-group-custom mb-4">
                <label for="concepto" class="form-label">Concepto</label>
                <input type="text" name="concepto" id="concepto" 
                       class="form-input-custom" 
                       value="{{ old('concepto', $pago->concepto) }}">
            </div>

            <div class="d-flex gap-2 pt-3">
                <button type="submit" class="btn-primary-custom">
                    <i class="fas fa-sync-alt"></i> Actualizar Pago
                </button>
                <a href="{{ route('alumnos.pagos', $pago->alumno_id) }}" class="btn-secondary-custom">
                    <i class="fas fa-times-circle"></i> Cancelar
                </a>
            </div>
        </form>
    @endif
</div>
@endsection