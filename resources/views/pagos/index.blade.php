@extends('layouts.app')

@section('content')
<h2>Pagos – Historial de {{ $alumno->nombre }} {{ $alumno->apellido }}</h2>

{{-- ------------------------------------------------------------- --}}
{{-- INFORMACIÓN DEL ALUMNO (NUEVA SECCIÓN CON FOTO) --}}
{{-- Reutilizamos la clase admin-card y el estilo de info-cartilla --}}
{{-- ------------------------------------------------------------- --}}
<div class="admin-card mb-4 info-alumno-cartilla"> 
    <div class="info-body">
        
        {{-- Foto del alumno --}}
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
            <p class="mb-0"><strong>Último Pago:</strong> 
                @if ($alumno->pagoDelMes())
                    <span class="badge-pago pago-aldia">Al día</span>
                @else
                    <span class="badge-pago pago-deuda">Pendiente</span>
                @endif
            </p>
        </div>
    </div>
</div>
{{-- ------------------------------------------------------------- --}}


@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

{{-- Formulario para registrar nuevo pago (Usamos admin-card como contenedor) --}}
<div class="admin-card mb-4">
    <div class="card-body">
        <h5>Registrar nuevo pago</h5>
        <form method="POST" action="{{ route('alumnos.pagos.store', $alumno->id) }}" class="row g-2">
            @csrf
            
            {{-- Monto --}}
            <div class="col-md-4 form-group-custom">
                <label for="monto" class="form-label">Monto (S/)</label>
                <input type="number" name="monto" id="monto" step="0.01" min="0" class="form-input-custom" required>
            </div>
            
            {{-- Fecha --}}
            <div class="col-md-4 form-group-custom">
                <label for="fecha_pago" class="form-label">Fecha</label>
                <input type="date" name="fecha_pago" id="fecha_pago" class="form-input-custom" required>
            </div>
            
            {{-- Concepto --}}
            <div class="col-md-4 form-group-custom">
                <label for="concepto" class="form-label">Concepto</label>
                <input type="text" name="concepto" id="concepto" class="form-input-custom" placeholder="Opcional">
            </div>
            
            {{-- Botón de Enviar --}}
            <div class="col-12 mt-3">
                <button type="submit" class="btn-primary-custom">
                    <i class="fas fa-money-check-alt"></i> Registrar Pago
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Tabla de pagos --}}
@if($pagos->isEmpty())
    <div class="alert alert-info admin-card">
        <i class="fas fa-info-circle"></i> No hay pagos registrados.
    </div>
@else
    <div class="admin-card">
        <table class="data-table align-middle">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Concepto</th>
                    <th>Monto (S/)</th>
                    <th>Estado</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pagos as $pago)
                    <tr @if($pago->estado === 'anulado') class="fila-anulada" @endif>
                        <td>{{ $pago->fecha_pago->format('Y-m-d') }}</td>
                        <td>{{ $pago->concepto ?? '-' }}</td>
                        <td>S/ {{ number_format($pago->monto, 2) }}</td>
                        <td>
                            @if($pago->estado === 'activo')
                                <span class="badge-pago pago-aldia">Activo</span>
                            @else
                                <span class="badge-pago pago-anulado">Anulado</span>
                            @endif
                        </td>
                        <td class="d-flex justify-content-center gap-1">
                            @if($pago->estado !== 'anulado')
                                <a href="{{ route('pagos.edit', $pago->id) }}" class="btn-action btn-editar" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('pagos.destroy', $pago->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-action btn-danger-custom" onclick="return confirm('¿Está seguro de ANULAR este pago? Esto no se puede deshacer.')" title="Anular Pago">
                                        <i class="fas fa-ban"></i>
                                    </button>
                                </form>
                            @else
                                <span class="badge-pago pago-anulado">Anulado</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2" class="text-end">Total Pagado (activos):</th>
                    <th>
                        S/ {{ number_format($pagos->where('estado', 'activo')->sum('monto'), 2) }}
                    </th>
                    <th colspan="2"></th>
                </tr>
            </tfoot>
        </table>
    </div>
@endif
@endsection