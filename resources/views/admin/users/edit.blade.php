@extends('layouts.admin') {{-- Asegúrate de usar el layout correcto del administrador --}}

@section('title', 'Editar Usuario: ' . $user->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <h1 class="h3 mb-4 text-gray-800">
                <i class="fas fa-edit me-2"></i> Editando Usuario: {{ $user->name }}
            </h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Actualizar Detalles del Usuario</h6>
                </div>
                <div class="card-body">
                    
                    {{-- 🛑 Formulario de Edición 🛑 --}}
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        {{-- Laravel requiere el método PUT o PATCH para la actualización en rutas resource --}}
                        @method('PUT') 
                        
                        {{-- Campo Nombre --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre Completo</label>
                            {{-- old() para manejar errores, $user->name para el valor actual --}}
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Campo Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Campo Contraseña (Opcional) --}}
                        <div class="mb-3">
                            <label for="password" class="form-label">Nueva Contraseña (Dejar vacío para no cambiar)</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Campo Confirmar Contraseña --}}
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                            <small class="form-text text-muted">La contraseña solo se actualizará si ingresas algo aquí.</small>
                        </div>
                        
                        {{-- Campo Rol/Permisos --}}
                        <div class="mb-4">
                            <label for="role" class="form-label">Rol del Usuario</label>
                            <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                {{-- Usamos old() o $user->role para mantener la selección actual --}}
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrador</option>
                                <option value="editor" {{ old('role', $user->role) == 'editor' ? 'selected' : '' }}>Editor / Staff</option>
                                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>Usuario Estándar (Alumno)</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>
                        
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Volver al Listado
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Guardar Cambios
                            </button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection