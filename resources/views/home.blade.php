@extends('layouts.app')

{{-- Importamos la clase Carbon para formateo de fechas --}}
@php use Carbon\Carbon; @endphp

@section('title', 'Dashboard - Panel de Control')

@section('content')

{{-- 🛑 ENCABEZADO PROFESIONAL 🛑 --}}
<h1 class="mb-3 text-dark"><i class="fas fa-chart-line me-2 text-primary"></i> Visión General del Club</h1>
<p class="lead text-muted">Panel de control y métricas clave en tiempo real. Bienvenido, {{ Auth::user()->name ?? 'Administrador' }}.</p>
<hr class="mb-5">

<div class="row">
    
    {{-- ================================================= --}}
    {{-- 🛑 COLUMNA PRINCIPAL (9/12) - REDUCIDA Y SIMPLIFICADA --}}
    {{-- ================================================= --}}
    <div class="col-lg-9">
        
        {{-- 1. TARJETAS DE RESUMEN (Solo Total y Activos) --}}
        <div class="row mb-5">
            
            {{-- Tarjeta 1: Total de Alumnos --}}
            {{-- Usamos col-md-4 para que ocupe más espacio al eliminar dos tarjetas --}}
            <div class="col-md-4 mb-3">
                <div class="card card-kpi shadow-sm h-100 bg-primary text-white">
                    <div class="card-body">
                        <div class="text-uppercase fw-bold small opacity-75">Total de Alumnos</div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="h2 mb-0 fw-light">{{ $totalAlumnos }}</div>
                            <i class="fas fa-users fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tarjeta 2: Alumnos Activos --}}
            {{-- Usamos col-md-4 para que ocupe más espacio al eliminar dos tarjetas --}}
            <div class="col-md-4 mb-3">
                <div class="card card-kpi shadow-sm h-100 bg-success text-white">
                    <div class="card-body">
                        <div class="text-uppercase fw-bold small opacity-75">Alumnos Activos</div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="h2 mb-0 fw-light">{{ $alumnosActivos }}</div>
                            <i class="fas fa-user-check fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Espacio vacío para rellenar la fila --}}
            <div class="col-md-4 mb-3">
                <div class="card h-100 bg-light text-muted border-dashed" style="border: 2px dashed #ccc;">
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <small>Espacio para métricas futuras.</small>
                    </div>
                </div>
            </div>
            
        </div>
        
        {{-- 🛑 ELIMINADO: GRÁFICA DE DISTRIBUCIÓN 🛑 --}}

        {{-- 3. Bloques de Noticias y Eventos --}}
        <div class="row mt-5">
            
            {{-- Bloque de Últimas Noticias --}}
            <div class="col-md-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header bg-dark text-white fw-bold">
                        <i class="fas fa-newspaper me-1"></i> Noticias Recientes
                    </div>
                    <div class="list-group list-group-flush list-group-hover">
                        @forelse ($ultimasNoticias as $noticia)
                            <a href="{{ route('noticias.edit', $noticia) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <span class="text-truncate">{{ $noticia->titulo }}</span>
                                <small class="text-muted text-end ms-2">{{ $noticia->created_at->diffForHumans() }}</small>
                            </a>
                        @empty
                            <div class="list-group-item text-center text-muted">No hay noticias recientes.</div>
                        @endforelse
                    </div>
                    <div class="card-footer text-end p-2 border-top-0">
                        <a href="{{ route('noticias.index') }}" class="small text-decoration-none text-dark">Ver todas <i class="fas fa-arrow-right small ms-1"></i></a>
                    </div>
                </div>
            </div>

            {{-- Bloque de Próximos Eventos --}}
            <div class="col-md-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header bg-dark text-white fw-bold">
                        <i class="fas fa-calendar-alt me-1"></i> Próximos Eventos
                    </div>
                    <div class="list-group list-group-flush list-group-hover">
                        @forelse ($proximosEventos as $evento)
                            <a href="{{ route('eventos.show', $evento) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <span class="text-truncate">{{ $evento->nombre }}</span>
                                <span class="badge bg-primary rounded-pill">{{ Carbon::parse($evento->fecha)->format('d M') }}</span>
                            </a>
                        @empty
                            <div class="list-group-item text-center text-muted">No hay eventos próximos.</div>
                        @endforelse
                    </div>
                    <div class="card-footer text-end p-2 border-top-0">
                        <a href="{{ route('eventos.index') }}" class="small text-decoration-none text-dark">Ver todos <i class="fas fa-arrow-right small ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    
    {{-- ================================================= --}}
    {{-- 🛑 COLUMNA DERECHA (3/12) - ENLACES RÁPIDOS Y REGISTROS --}}
    {{-- ================================================= --}}
    <div class="col-lg-3">
        
        {{-- Tarjeta de Acción Rápida (Asistencia) --}}
        <div class="card bg-info shadow-lg mb-4 hover-scale">
            <a href="{{ route('asistencias.index') }}" class="card-body text-white text-center text-decoration-none py-4">
                <i class="fas fa-fingerprint fa-2x mb-2"></i>
                <h5 class="mb-0 fw-bold">REGISTRAR ASISTENCIA</h5>
                <small class="opacity-75">Click para iniciar el registro diario.</small>
            </a>
        </div>
        
        {{-- Últimos Registros --}}
        <div class="card shadow h-100">
            <div class="card-header bg-secondary text-white fw-bold">
                <i class="fas fa-history me-1"></i> Últimos 5 Registros
            </div>
            <div class="list-group list-group-flush list-group-hover">
                @forelse ($ultimosAlumnos as $alumno)
                    <a href="{{ route('alumnos.show', $alumno) }}" class="list-group-item list-group-item-action">
                        <div class="d-flex flex-column">
                            <strong class="text-dark">{{ $alumno->nombre }} {{ $alumno->apellido }}</strong>
                            <small class="text-muted">{{ $alumno->created_at->format('d M Y') }}</small>
                        </div>
                    </a>
                @empty
                    <div class="list-group-item text-center text-muted">Aún no hay alumnos registrados.</div>
                @endforelse
            </div>
            <div class="card-footer text-end p-2 border-top-0">
                <a href="{{ route('alumnos.index') }}" class="small text-decoration-none text-dark">Ver listado completo <i class="fas fa-arrow-right small ms-1"></i></a>
            </div>
        </div>
    </div>

</div>

{{-- 🛑 JAVASCRIPT Y CSS PERSONALIZADO (Solo Estilos) 🛑 --}}
@push('scripts')
<style>
/* CSS EXTRA PARA HACERLO MÁS PROFESIONAL Y DINÁMICO */
.card-kpi {
    transition: transform 0.2s, box-shadow 0.2s;
    border-radius: 0.5rem; 
    border: none;
}
.card-kpi:hover {
    transform: translateY(-5px); 
    box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important; 
}

/* Efecto de escalado para tarjetas de acción */
.hover-scale {
    transition: transform 0.3s ease;
}
.hover-scale:hover {
    transform: scale(1.03); 
    z-index: 10;
}

/* Efecto hover sutil para listas */
.list-group-hover .list-group-item-action:hover {
    background-color: #f8f9fa; 
    border-left: 4px solid #007bff; 
}
</style>
@endpush

@endsection