@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    {{-- Usamos col-md-8 y admin-card como contenedor principal --}}
    <div class="col-md-8"> 
        
        <h2 class="mb-4">Registrar Alumno</h2>

        {{-- Mostrar errores de validación (usamos la alerta de Bootstrap, ya cargada) --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Contenedor del formulario con estilo de tarjeta --}}
        <div class="admin-card"> 

            <form method="POST"
                action="{{ route('alumnos.store') }}"
                enctype="multipart/form-data">
                @csrf

                <div class="form-group-custom mb-3">
                    <label class="form-label">Nombre *</label>
                    {{-- Usamos la clase personalizada para inputs --}}
                    <input type="text"
                           name="nombre"
                           class="form-input-custom" 
                           value="{{ old('nombre') }}"
                           required>
                </div>

                <div class="form-group-custom mb-3">
                    <label class="form-label">Apellido *</label>
                    <input type="text"
                           name="apellido"
                           class="form-input-custom"
                           value="{{ old('apellido') }}"
                           required>
                </div>

                <div class="form-group-custom mb-3">
                    <label class="form-label">Fecha de nacimiento *</label>
                    <input type="date"
                           name="fecha_nacimiento"
                           class="form-input-custom"
                           value="{{ old('fecha_nacimiento') }}"
                           required>
                </div>

                <div class="form-group-custom mb-3">
                    <label class="form-label">Categoría *</label>
                    {{-- Usamos la clase personalizada para select --}}
                    <select name="categoria_id"
                            class="form-select-custom" 
                            required>
                        <option value="">Seleccione una categoría</option>
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id }}"
                                {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group-custom mb-4">
                    <label class="form-label">Foto (opcional)</label>
                    {{-- Usamos la clase personalizada para archivo --}}
                    <input type="file"
                           name="foto"
                           class="form-file-custom" 
                           accept="image/*">
                </div>

                <div class="d-flex gap-2 pt-3">
                    {{-- Usamos clases semánticas para los botones --}}
                    <button type="submit" class="btn-primary-custom">
                        <i class="fas fa-save"></i> Guardar
                    </button>

                    <a href="{{ route('alumnos.index') }}" class="btn-secondary-custom">
                        <i class="fas fa-times-circle"></i> Cancelar
                    </a>
                </div>

            </form>
        </div> {{-- Cierre de admin-card --}}

    </div>
</div>
@endsection