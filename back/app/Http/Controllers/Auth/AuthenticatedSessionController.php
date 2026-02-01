<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Mostrar vista de login
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Procesar autenticación y redirigir según ROL REAL
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        // 🔐 REDIRECCIÓN SEGÚN ROLES DE TU BD
        if ($user->hasRole('Admin')) {
            return redirect()->route('dashboard');
        }

        if ($user->hasRole('Alumno')) {
            return redirect()->route('alumnos.perfil', $user->id);
        }

        if ($user->hasRole('Ventas')) {
            return redirect()->route('ventas.index');
        }

        if ($user->hasRole('Estudiante')) {
            return redirect()->route('home');
        }

        if ($user->hasRole('cliente')) {
            return redirect()->route('home');
        }

        // 🔁 Fallback seguro
        return redirect()->route('home');
    }

    /**
     * Cerrar sesión
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
