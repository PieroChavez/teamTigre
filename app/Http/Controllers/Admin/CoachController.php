<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;
use App\Models\Category;
use App\Models\CoachProfile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash; 

class CoachController extends Controller
{
    
    // ... (index y create se mantienen iguales)
    public function index()
    {
        $coaches = User::whereHas('role', function ($q) {
            $q->where('name', 'coach');
        })
        ->with('coachProfile') 
        ->orderBy('name')
        ->get();

        return view('admin.coaches.index', compact('coaches'));
    }

    public function create()
    {
        return view('admin.coaches.create');
    }

    // =========================================================
    // ✅ MÉTODO STORE ACTUALIZADO
    // =========================================================
    public function store(Request $request)
    {
        // 1. Validación de Datos (birth_date se incluye para guardar)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'dni' => 'nullable|string|max:20|unique:coach_profiles,dni',
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date', // <-- Ahora SÍ se guarda
            'certifications' => 'nullable|string',
            'bio' => 'nullable|string',
            'status' => 'required|in:activo,inactivo,ausente', 
        ]);
        
        $coachRole = Role::where('name', 'coach')->firstOrFail();

        // 💡 MAPEO DE ESTADOS (Español de la vista a Inglés/BD)
        $statusMapping = [
            'activo'   => 'active',
            'inactivo' => 'inactive',
            'ausente'  => 'inactive', 
        ];
        
        DB::beginTransaction();
        
        try {
            // 2. Crear el Usuario (Rol 'coach' fijo)
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password), 
                'role_id' => $coachRole->id, 
            ]);

            // 3. Crear el Perfil del Coach (CoachProfile)
            $user->coachProfile()->create([
                'dni' => $request->dni,
                'phone' => $request->phone,
                'birth_date' => $request->birth_date, // <-- AGREGADO
                
                // Mapeamos 'certifications' del request al campo 'specialty' de la BD
                'specialty' => $request->certifications, 
                
                // Usamos el campo 'notes' de la BD para guardar el 'bio' del formulario
                'notes' => $request->bio, 
                
                // Aplicar mapeo de status
                'status' => $statusMapping[strtolower($request->status)] ?? 'inactive', 
            ]);
            
            DB::commit();

            return redirect()->route('admin.coaches.index')
                             ->with('success', 'Entrenador ' . $user->name . ' registrado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear coach: ' . $e->getMessage());
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Error al registrar el entrenador. Razón: ' . $e->getMessage()); 
        }
    }

    // ... (edit se mantiene igual)
    public function edit(User $coach)
    {
        $coach->load('coachProfile.categories');
        $categories = Category::orderBy('name')->get(); 
        return view('admin.coaches.edit', compact('coach', 'categories'));
    }

    // =========================================================
    // ✅ MÉTODO UPDATE ACTUALIZADO
    // =========================================================
    public function update(Request $request, User $coach)
    {
        // 1. Validación de Datos
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $coach->id,
            'password' => 'nullable|string|confirmed|min:8', 
            // Usamos optional() para obtener el ID de coachProfile solo si existe, mejorando la unicidad
            'dni' => 'nullable|string|max:20|unique:coach_profiles,dni,' . optional($coach->coachProfile)->id . ',id',
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date', // <-- Ahora SÍ se guarda
            'certifications' => 'nullable|string',
            'bio' => 'nullable|string',
            'status' => 'required|in:activo,inactivo,ausente', 
            'categories' => 'nullable|array', 
            'categories.*' => 'exists:categories,id',
        ]);

        // 💡 MAPEO DE ESTADOS (Español de la vista a Inglés/BD)
        $statusMapping = [
            'activo'   => 'active',
            'inactivo' => 'inactive',
            'ausente'  => 'inactive', 
        ];
        
        DB::beginTransaction();

        try {
            // 2. Actualizar el Usuario
            $coach->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            if ($request->filled('password')) {
                $coach->update(['password' => Hash::make($request->password)]); 
            }

            // 3. Actualizar o Crear el Perfil del Coach
            $coachProfile = $coach->coachProfile()->updateOrCreate(
                ['user_id' => $coach->id],
                [
                    'dni' => $request->dni,
                    'phone' => $request->phone,
                    'birth_date' => $request->birth_date, // <-- AGREGADO
                    
                    // Mapeamos 'certifications' del request al campo 'specialty' de la BD
                    'specialty' => $request->certifications,
                    
                    // Usamos el campo 'notes' de la BD para guardar el 'bio' del formulario
                    'notes' => $request->bio,
                    
                    // Aplicar mapeo de status
                    'status' => $statusMapping[strtolower($request->status)] ?? 'inactive',
                ]
            );

            // 4. Sincronizar las Categorías Asignadas (Many-to-Many)
            if ($coachProfile) {
                $categoriesToSync = $request->input('categories', []);
                $coachProfile->categories()->sync($categoriesToSync); 
            }
            
            DB::commit(); 
            
            return redirect()->route('admin.coaches.index')
                             ->with('success', 'Entrenador ' . $coach->name . ' actualizado y categorías sincronizadas exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar coach: ' . $e->getMessage());
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Error al actualizar el entrenador. Razón: ' . $e->getMessage());
        }
    }

    // ... (destroy, coachAreaIndex y show se mantienen iguales)
    public function destroy(User $coach)
    {
        DB::beginTransaction();

        try {
            if ($coach->coachProfile) {
                // Cambiamos el estado a 'inactive' directamente en la base de datos
                $coach->coachProfile->update(['status' => 'inactive']); 
            }
            
            DB::commit();
            
            return redirect()->back()
                             ->with('success', 'Entrenador ' . $coach->name . ' desactivado (estado: inactivo).');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al desactivar coach: ' . $e->getMessage());
            return redirect()->back()
                             ->with('error', 'Error al desactivar el entrenador. Razón: ' . $e->getMessage());
        }
    }
    
    // ... (resto de métodos coachAreaIndex y show se mantienen iguales)
    public function coachAreaIndex()
    {
        $coach = Auth::user();
        $coachProfile = $coach->coachProfile()->with('categories')->first(); 
        
        if (!$coachProfile || $coachProfile->categories->isEmpty()) {
            $students = collect();
            return view('coach.students.index', compact('students'));
        }

        $categoryIds = $coachProfile->categories->pluck('id');

        $students = User::whereHas('studentProfile.enrollments', function ($query) use ($categoryIds) {
            $query->whereIn('category_id', $categoryIds)
                  ->where('status', 'activo'); 
        })
        ->with(['studentProfile' => function ($q) use ($categoryIds) { 
            $q->with(['enrollments' => function ($e) use ($categoryIds) {
                $e->where('status', 'activo')
                  ->whereIn('category_id', $categoryIds)
                  ->with(['category', 'plan']);
            }]);
        }])
        ->orderBy('name')
        ->get();

        return view('coach.students.index', compact('students'));
    }

    public function show(User $student)
    {
        $coach = Auth::user();
        $coachProfile = $coach->coachProfile()->with('categories')->first();

        if (!$coachProfile || $coachProfile->categories->isEmpty()) {
            abort(403, 'Acceso denegado: No tiene categorías asignadas.');
        }
        $coachCategoryIds = $coachProfile->categories->pluck('id')->toArray();

        $student->load([
            'studentProfile' => function ($q) use ($coachCategoryIds) {
                $q->with(['enrollments' => function ($e) use ($coachCategoryIds) {
                    $e->where('status', 'activo')
                      ->whereIn('category_id', $coachCategoryIds) 
                      ->with(['category', 'plan']);
                }]);
            },
        ]);
        
        if (!$student->studentProfile) {
            abort(404, 'Perfil de estudiante no encontrado.'); 
        }

        $hasActiveEnrollmentInCoachCategory = $student->studentProfile->enrollments->isNotEmpty();

        if (!$hasActiveEnrollmentInCoachCategory) {
            abort(403, 'Acceso denegado. Este alumno no está en ninguna de tus categorías activas.');
        }

        return view('coach.students.show', compact('student'));
    }
}