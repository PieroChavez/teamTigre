<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Importamos los traits de autenticación de Laravel
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthController extends Controller
{
    // Usamos el trait AuthenticatesUsers para manejar la lógica de login y logout
    use AuthenticatesUsers;

    /**
     * Dónde redirigir a los usuarios después de iniciar sesión.
     * Esto redirigirá al usuario a la ruta con el nombre 'home' (que definimos como /home en routes/web.php).
     * @var string
     */
    protected $redirectTo = '/home'; // O '/admin/dashboard' si prefieres esa ruta

    /**
     * Muestra el formulario de login.
     * Corresponde a la ruta GET /login
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        // El nombre de la vista que creamos en el paso anterior.
        return view('auth.login');
    }

    /**
     * Maneja el intento de login (POST /login).
     * Este método es provisto por el trait AuthenticatesUsers
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    // NOTA: El método login(Request $request) ya está definido en el trait,
    // por lo que no necesitas escribirlo aquí, a menos que quieras personalizarlo.


    /**
     * Cierra la sesión del usuario (POST /logout).
     * Este método es provisto por el trait AuthenticatesUsers
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    // NOTA: El método logout(Request $request) también está definido en el trait.

    // Si quieres personalizar el campo de autenticación (ej: usar 'nombre_usuario' en lugar de 'email'),
    // puedes sobrescribir el método username():
    /*
    public function username()
    {
        return 'nombre_usuario';
    }
    */
}