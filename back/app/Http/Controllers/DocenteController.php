<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

// !!! Importación de los Form Requests necesarios !!!
use App\Http\Requests\StoreDocenteRequest; 
use App\Http\Requests\UpdateDocenteRequest; 

class DocenteController extends Controller
{
    /**
     * Muestra una lista de todos los docentes con filtros y búsqueda.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $estado = $request->input('estado');

        $query = Docente::query();

        // Aplicar filtros de búsqueda
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('dni', 'like', "%{$search}%")
                  // Buscar por nombre de usuario (relación user)
                  ->orWhereHas('user', function ($q_user) use ($search) {
                      $q_user->where('name', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhere('especialidad', 'like', "%{$search}%");
            });
        }
        
        // Aplicar filtro de estado
        if ($estado && $estado !== 'todos') {
            $query->where('estado', $estado);
        }

        $docentes = $query->with('user') // Cargar la información del usuario asociado
                          ->orderBy('id', 'desc')
                          ->paginate(10);

        return view('docentes.index', compact('docentes', 'search', 'estado'));
    }

    /**
     * Muestra el formulario para crear un nuevo docente.
     */
    public function create()
    {
        $especialidades = ['Boxeo', 'Kickboxing', 'MMA', 'Fitness']; 
        return view('docentes.create', compact('especialidades')); 
    }

    /**
     * Almacena un recurso recién creado en el almacenamiento.
     * !!! USANDO StoreDocenteRequest para la validación !!!
     */
    public function store(StoreDocenteRequest $request)
    {
        // La validación se ejecuta automáticamente por StoreDocenteRequest
        
        DB::transaction(function () use ($request) {
            
            // 1. Crear el registro de usuario (Login)
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'docente', // Asumido
            ]);

            // 2. Crear el registro de docente (Datos específicos)
            Docente::create([
                'user_id' => $user->id,
                'dni' => $request->dni,
                'telefono' => $request->telefono,
                'especialidad' => $request->especialidad,
                'experiencia' => $request->experiencia,
                'estado' => 'activo',
            ]);
        });
        
        return redirect()->route('docentes.index')->with('success', '✅ Docente y usuario de login creados exitosamente.');
    }

    /**
     * Muestra el perfil detallado del docente.
     */
    public function show(Docente $docente)
    {
        // Carga las relaciones para mostrar el perfil completo
        $docente->load(['user', 'horarios.categoria']); 
        return view('docentes.show', compact('docente'));
    }

    /**
     * Muestra el formulario para editar el recurso especificado.
     */
    public function edit(Docente $docente)
    {
        $docente->load('user');
        $especialidades = ['Boxeo', 'Kickboxing', 'MMA', 'Fitness']; 
        return view('docentes.edit', compact('docente', 'especialidades')); 
    }

    /**
     * Actualiza el recurso especificado en el almacenamiento.
     * !!! USANDO UpdateDocenteRequest para la validación !!!
     */
    public function update(UpdateDocenteRequest $request, Docente $docente)
    {
        // La validación se ejecuta automáticamente por UpdateDocenteRequest
        
        DB::transaction(function () use ($request, $docente) {
            
            // 1. Actualizar el registro de usuario
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $docente->user->update($userData);

            // 2. Actualizar el registro de docente
            $docente->update([
                'dni' => $request->dni,
                'telefono' => $request->telefono,
                'especialidad' => $request->especialidad,
                'estado' => $request->estado,
                'experiencia' => $request->experiencia,
            ]);
        });
        
        // REDIRECCIÓN A SHOW CON ÉXITO
        return redirect()->route('docentes.show', $docente->id)->with('success', '✏️ Docente y sus credenciales actualizados exitosamente.');
    }

    /**
     * Elimina el recurso especificado del almacenamiento.
     */
    public function destroy(Docente $docente)
    {
        DB::transaction(function () use ($docente) {
            // Se elimina la cuenta de usuario. 
            if ($docente->user) {
                $docente->user->delete(); 
            } else {
                 $docente->delete(); 
            }
        });

        return redirect()->route('docentes.index')->with('success', '🗑️ Docente y su cuenta de usuario eliminados correctamente.');
    }

    // ====================================
    // MÉTODOS ADICIONALES (Rutas personalizadas)
    // ====================================

    /**
     * Muestra el perfil detallado del docente (se redirige a show).
     */
    public function perfil(Docente $docente)
    {
        return $this->show($docente);
    }

    /**
     * Muestra las clases o horarios asignados al docente.
     */
    public function clasesAsignadas(Docente $docente)
    {
        // Se cargan los horarios y la información de la categoría asociada
        $clases = $docente->horarios()->with('categoria')->get();
        
        return view('docentes.clases', compact('docente', 'clases'));
    }
}