@extends('layouts.admin') {{-- O la plantilla que uses para el panel de control --}}

@section('title', 'Crear Nuevo Usuario Administrador')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <h1 class="h3 mb-4 text-gray-800">
                <i class="fas fa-user-plus me-2"></i> Registrar Nuevo Usuario
            </h1>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Detalles del Usuario</h6>
                </div>
                <div class="card-body">
                    
                    {{-- 🛑 Formulario de Creación de Usuario 🛑 --}}
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf
                        
                        {{-- Campo Nombre --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre Completo</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Campo Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Campo Contraseña --}}
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Campo Confirmar Contraseña --}}
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                        
                        {{-- Campo Rol/Permisos (Crucial para crear un ADMIN) --}}
                        <div class="mb-4">
                            <label for="role" class="form-label">Rol del Usuario</label>
                            <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                <option value="" disabled selected>Seleccione un rol</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
                                <option value="editor" {{ old('role') == 'editor' ? 'selected' : '' }}>Editor / Staff</option>
                                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Usuario Estándar (Alumno)</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Selecciona 'Administrador' para otorgar permisos de gestión completa.</small>
                        </div>

                        <hr>
                        
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Crear Usuario
                            </button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection