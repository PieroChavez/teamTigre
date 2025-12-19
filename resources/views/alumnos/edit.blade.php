@extends('layouts.admin') {{-- Asegúrate de usar tu layout de administrador --}}

@section('title', 'Editar Alumno: ' . $alumno->nombre . ' ' . $alumno->apellido)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-10 offset-lg-1">
            <h1 class="h3 mb-4 text-gray-800">
                <i class="fas fa-user-edit me-2"></i> Editando Alumno: {{ $alumno->nombre }}
            </h1>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Información del Alumno</h6>
                </div>
                <div class="card-body">
                    
                    {{-- Formulario de Edición con soporte para archivos (enctype) --}}
                    <form action="{{ route('alumnos.update', $alumno->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- Laravel requiere el método PUT/PATCH para actualizar recursos --}}
                        @method('PUT') 
                        
                        <div class="row">
                            {{-- Columna 1: Datos Personales --}}
                            <div class="col-md-6">
                                
                                {{-- Campo Nombre --}}
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre', $alumno->nombre) }}" required>
                                    @error('nombre')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Campo Apellido --}}
                                <div class="mb-3">
                                    <label for="apellido" class="form-label">Apellido</label>
                                    <input type="text" class="form-control @error('apellido') is-invalid @enderror" id="apellido" name="apellido" value="{{ old('apellido', $alumno->apellido) }}" required>
                                    @error('apellido')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Campo Fecha de Nacimiento --}}
                                <div class="mb-3">
                                    <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                                    <input type="date" class="form-control @error('fecha_nacimiento') is-invalid @enderror" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $alumno->fecha_nacimiento) }}" required>
                                    @error('fecha_nacimiento')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                {{-- Campo Categoría --}}
                                <div class="mb-3">
                                    <label for="categoria_id" class="form-label">Categoría</label>
                                    <select class="form-select @error('categoria_id') is-invalid @enderror" id="categoria_id" name="categoria_id" required>
                                        <option value="" disabled>Seleccione una Categoría</option>
                                        @foreach($categorias as $categoria)
                                            <option value="{{ $categoria->id }}" 
                                                {{ old('categoria_id', $alumno->categoria_id) == $categoria->id ? 'selected' : '' }}>
                                                {{ $categoria->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('categoria_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            {{-- Columna 2: Foto y Botones --}}
                            <div class="col-md-6">
                                
                                {{-- Foto Actual --}}
                                <div class="mb-3 text-center">
                                    <label class="form-label d-block">Foto Actual:</label>
                                    @if ($alumno->foto)
                                        <img src="{{ asset('storage/' . $alumno->foto) }}" alt="Foto de {{ $alumno->nombre }}" class="img-thumbnail" style="max-width: 150px; max-height: 150px; object-fit: cover;">
                                        <p class="mt-2 text-muted small">La foto será reemplazada al subir una nueva.</p>
                                    @else
                                        <p class="text-muted">No hay foto actual.</p>
                                    @endif
                                </div>

                                {{-- Campo Subir Nueva Foto --}}
                                <div class="mb-4">
                                    <label for="foto" class="form-label">Subir Nueva Foto (Máx 2MB)</label>
                                    <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto" accept="image/jpeg,image/png">
                                    @error('foto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <hr>
                                
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('alumnos.index') }}" class="btn btn-secondary me-2">
                                        <i class="fas fa-arrow-left"></i> Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save"></i> Guardar Cambios
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection