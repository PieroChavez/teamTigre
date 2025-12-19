@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h2>Alumnos</h2>
    {{-- Se recomienda usar una clase semántica como btn-custom-action en admin.css --}}
    <a href="{{ route('alumnos.create') }}" class="btn-custom-action"> 
        <i class="fas fa-user-plus"></i> + Nuevo Alumno
    </a>
</div>

@if ($alumnos->count())
<div class="admin-card"> {{-- Usamos admin-card para el contenedor de la tarjeta --}}
    <table class="data-table align-middle"> {{-- Usamos data-table (definida en admin.css) --}}
        <thead>
            <tr>
                <th>Foto</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th class="text-center">Pago</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($alumnos as $alumno)
            <tr>
                <td>
                    @if ($alumno->foto)
                        <img src="{{ asset('storage/' . $alumno->foto) }}"
                             alt="{{ $alumno->nombre }}"
                             class="rounded-circle-foto"> {{-- Clase de admin.css --}}
                    @else
                        <span class="text-muted">Sin foto</span>
                    @endif
                </td>

                <td>{{ $alumno->nombre }} {{ $alumno->apellido }}</td>

                <td>
                    <span class="badge-categoria">{{ $alumno->categoria->nombre }}</span>
                </td>

                <td class="text-center">
                    @if ($alumno->pagoDelMes())
                        {{-- Clases semánticas para badges --}}
                        <span class="badge-pago pago-aldia">Al día</span> 
                    @else
                        <span class="badge-pago pago-deuda">Deuda</span> 
                    @endif
                </td>

                <td class="d-flex gap-1 justify-content-center">
                    {{-- Clases semánticas para botones de acción --}}
                    <a href="{{ route('alumnos.asistencias', $alumno->id) }}"
                       class="btn-action btn-cartilla" title="Cartilla">
                       <i class="fas fa-calendar-check"></i> 
                    </a>

                    <a href="{{ route('alumnos.pagos', $alumno->id) }}"
                       class="btn-action btn-pagos" title="Pagos">
                       <i class="fas fa-money-bill-wave"></i>
                    </a>

                    <a href="#" class="btn-action btn-editar" title="Editar">
                       <i class="fas fa-edit"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<div class="alert alert-info admin-card"> {{-- Usamos admin-card como contenedor --}}
    <i class="fas fa-info-circle"></i> No hay alumnos registrados.
</div>
@endif
@endsection