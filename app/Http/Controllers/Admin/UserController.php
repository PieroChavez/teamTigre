<?php

namespace App\Http\Controllers\Admin; // Asegúrate de que el namespace sea el correcto
// Si no usas namespace, puedes eliminar esta línea y la siguiente
use App\Http\Controllers\Controller; 

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; // Necesario para la validación 'unique' en update

class UserController extends Controller
{
    /**
     * Mostrar la lista de todos los usuarios.
     * Corresponde a la vista admin/users/index.blade.php
     */
    public function index()
    {
        // Recupera todos los usuarios con paginación
        $users = User::orderBy('id', 'desc')->paginate(15); 
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     * Corresponde a la vista admin/users/create.blade.php
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Almacena un nuevo usuario en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,editor,user',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, 
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Muestra el formulario para editar un usuario específico.
     * Corresponde a la vista admin/users/edit.blade.php (Aún no creada)
     */
    public function edit(User $user) // Uso de Route Model Binding
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Actualiza la información de un usuario específico.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // Valida que el email sea único, ignorando al usuario actual
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            // La contraseña es opcional al editar, pero si se envía, debe ser validada
            'password' => 'nullable|string|min:8|confirmed', 
            'role' => 'required|in:admin,editor,user',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        
        // Solo actualiza la contraseña si se ha proporcionado una nueva
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Elimina un usuario de la base de datos.
     */
    public function destroy(User $user)
    {
        // Opcional: Impedir que un admin se elimine a sí mismo
        // if (auth()->id() == $user->id) {
        //     return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        // }
        
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado exitosamente.');
    }
}