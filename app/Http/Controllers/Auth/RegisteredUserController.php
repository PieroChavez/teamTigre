<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role; // ✅ Importación necesaria para trabajar con roles
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 1. Crear el nuevo usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // ======================================================
        // ✅ ASIGNAR ROL 'ALUMNO' AL REGISTRARSE
        // ======================================================
        
        // 2. Buscar el Rol 'alumno' por el campo 'nombre'
        $rolAlumno = Role::where('nombre', 'alumno')->first(); 

        if ($rolAlumno) {
            // 3. Adjuntar el rol al usuario en la tabla pivote (role_user)
            $user->roles()->attach($rolAlumno->id);
            
            // Opcional: Crear la entrada en la tabla 'alumnos' si es necesario.
            // Si necesitas el registro de Alumno (perfil) creado de inmediato:
            /*
            if (method_exists($user, 'alumno')) {
                $user->alumno()->create([]); 
            }
            */

        } else {
            // Manejo de error si el rol no existe (se recomienda loguear)
            // \Log::warning("El rol 'alumno' no se encontró. No se pudo asignar el rol al nuevo usuario.");
        }
        // ======================================================

        event(new Registered($user));

        Auth::login($user);

        // Redirección: Ya que es un Alumno, lo enviamos a su perfil específico
        // Esto requiere que el método alumno() en User sea HasOne y la ruta exista.
        return redirect()->route('alumnos.perfil', $user->alumno);
    }
}