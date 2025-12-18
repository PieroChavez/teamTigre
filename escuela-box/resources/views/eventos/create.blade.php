@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-4 align-items-center">
    <h2><i class="fas fa-calendar-plus me-2"></i> Nuevo Evento</h2>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        
        <form action="{{ route('eventos.store') }}" method="POST">
            @csrf
            
            {{-- Manejo de Errores de Validación --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Campo NOMBRE --}}
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Evento *</label>
                <input type="text" 
                       name="nombre" 
                       id="nombre" 
                       class="form-control @error('nombre') is-invalid @enderror" 
                       value="{{ old('nombre') }}" 
                       required>
                @error('nombre')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Campo FECHA --}}
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha del Evento *</label>
                <input type="date" 
                       name="fecha" 
                       id="fecha" 
                       class="form-control @error('fecha') is-invalid @enderror" 
                       value="{{ old('fecha') }}" 
                       required>
                @error('fecha')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Campo COSTO (Añadido: Asumo que los eventos tienen un costo) --}}
            <div class="mb-3">
                <label for="costo" class="form-label">Costo (S/)</label>
                <input type="number" 
                       name="costo" 
                       id="costo" 
                       class="form-control @error('costo') is-invalid @enderror" 
                       value="{{ old('costo') ?? 0 }}" 
                       min="0"
                       step="0.01">
                @error('costo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            {{-- Campo DESCRIPCIÓN --}}
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea name="descripcion" 
                          id="descripcion" 
                          class="form-control @error('descripcion') is-invalid @enderror" 
                          rows="3">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <hr>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Guardar Evento
                </button>
                <a href="{{ route('eventos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times-circle"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection