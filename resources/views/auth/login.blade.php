@extends('layouts.auth_full') 
{{-- 👆 Usamos un layout dedicado para la página de login --}}

@section('content')
<div class="login-container">
    <div class="card login-card shadow-lg border-0">
        <div class="card-header bg-dark text-white text-center">
            <h4 class="mb-0"><i class="fas fa-sign-in-alt me-2"></i> Acceso al Panel</h4>
        </div>
        <div class="card-body p-4">

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Campo de Email/Usuario --}}
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input id="email" 
                           type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autocomplete="email" 
                           autofocus>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Campo de Contraseña --}}
                <div class="mb-4">
                    <label for="password" class="form-label">Contraseña</label>
                    <input id="password" 
                           type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           name="password" 
                           required 
                           autocomplete="current-password">
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Recordarme --}}
                <div class="mb-4 form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        Recordarme
                    </label>
                </div>

                {{-- Botón de Login --}}
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">
                        Iniciar Sesión
                    </button>
                </div>
                
            </form>
        </div>
    </div>
</div>
@endsection