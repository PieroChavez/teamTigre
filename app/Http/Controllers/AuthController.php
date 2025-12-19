<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Importamos el trait de autenticación de Laravel para usar su lógica de Login y Logout
use Illuminate\Foundation\Auth\AuthenticatesUsers; 

class AuthController extends Controller
{
    // Usamos el trait AuthenticatesUsers para manejar la lógica de login y logout
    use AuthenticatesUsers;

    /**
     * Dónde redirigir a los usuarios después de iniciar sesión.
     * Debe coincidir con la ruta protegida que creamos: /home
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Muestra el formulario de login.
     * Corresponde a la ruta GET /login
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        // Esto carga la vista que creamos en resources/views/auth/login.blade.php
        return view('auth.login');
    }

    /*
     * NOTA: Los métodos login(Request $request) y logout(Request $request)
     * se obtienen automáticamente del trait AuthenticatesUsers,
     * por lo que no es necesario escribirlos aquí.
     */
    
    // Si quieres sobrescribir la lógica de Logout para, por ejemplo,
    // redirigir a la página de inicio pública en lugar de /login, puedes hacerlo aquí:
    /*
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $this->loggedOut($request) ?: redirect('/');
    }
    */
}