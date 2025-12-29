<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\User;
use App\Models\Category;
use App\Models\Plan; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class EnrollmentController extends Controller
{
    /**
     * LISTADO + FORMULARIO DE CREACIÓN
     */
    public function index()
        {
            // Cargar la relación 'plan' en la consulta principal
            $enrollments = Enrollment::with([
                'studentProfile.user',
                'category',
                'plan' 
            ])
            // 🎯 CORRECCIÓN 1: Ordenar por fecha de inicio descendente (más recientes primero)
            // 🎯 CORRECCIÓN 2: Paginación de 5 en 5
            ->orderByDesc('start_date') 
            ->paginate(5); 

            // Cargar alumnos con su perfil para el select del formulario
            $students = User::whereHas('role', function ($q) {
                $q->where('name', 'alumno'); 
            })
            ->with('studentProfile') 
            ->orderBy('name')
            ->get();

            $categories = Category::all();
            $plans = Plan::where('active', true)->get(); 

            return view('admin.enrollments.index', compact(
                'enrollments',
                'students', 
                'categories',
                'plans'
            ));
        }

    /**
     * GUARDAR NUEVA INSCRIPCIÓN
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_profile_id' => 'required|exists:student_profiles,id', 
            'category_id'        => 'required|exists:categories,id',
            'plan_id'            => 'required|exists:plans,id',
            'start_date'         => 'required|date',
            'end_date'           => 'nullable|date|after_or_equal:start_date',
        ]);

        DB::beginTransaction();

        try {
            // Lógica de negocio: Finalizar inscripciones activas previas del mismo alumno en la misma categoría
            Enrollment::where('student_profile_id', $request->student_profile_id)
                ->where('category_id', $request->category_id)
                ->where('status', 'active')
                ->update(['status' => 'finished']);

            Enrollment::create([
                'student_profile_id' => $request->student_profile_id,
                'category_id'        => $request->category_id,
                'plan_id'            => $request->plan_id,
                'start_date'         => $request->start_date,
                'end_date'           => $request->end_date, 
                'status'             => 'active',
            ]);

            DB::commit();

            return back()->with('success', 'Alumno inscrito correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en store de inscripción: ' . $e->getMessage()); 
            return back()->withErrors(['error' => 'No se pudo procesar la inscripción.'])->withInput();
        }
    }

    // El resto de los métodos CRUD (edit y update) se mantienen sin cambios mayores.

    /**
     * MOSTRAR FORMULARIO DE EDICIÓN
     */
    public function edit(Enrollment $enrollment)
    {
        $enrollment->load('studentProfile.user', 'category', 'plan'); 

        $categories = Category::all();
        $plans = Plan::where('active', true)->get(); 

        $students = User::whereHas('role', function ($q) {
            $q->where('name', 'alumno');
        })->with('studentProfile')->get();

        return view('admin.enrollments.edit', compact('enrollment', 'categories', 'students', 'plans'));
    }

    /**
     * ACTUALIZAR INSCRIPCIÓN
     */
    public function update(Request $request, Enrollment $enrollment)
    {
        $request->validate([
            'student_profile_id' => 'required|exists:student_profiles,id',
            'category_id'        => 'required|exists:categories,id',
            'plan_id'            => 'required|exists:plans,id', 
            'start_date'         => 'required|date',
            'end_date'           => 'nullable|date|after_or_equal:start_date', 
            'status'             => ['required', Rule::in(['active', 'suspended', 'finished'])],
        ]);

        try {
            $enrollment->update([
                'student_profile_id' => $request->student_profile_id,
                'category_id'        => $request->category_id,
                'plan_id'            => $request->plan_id, 
                'start_date'         => $request->start_date,
                'end_date'           => $request->end_date,
                'status'             => $request->status,
            ]);

            return redirect()
                ->route('admin.enrollments.index')
                ->with('success', 'Inscripción actualizada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error en update de inscripción: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error al actualizar los datos.'])->withInput();
        }
    }

    /**
     * FINALIZAR INSCRIPCIÓN (Usando el método DELETE estándar de REST)
     * En lugar de borrar, cambia el estado a 'finished'.
     */
    public function destroy(Enrollment $enrollment)
    {
        try {
            $enrollment->update(['status' => 'finished']);
            return back()->with('success', 'Inscripción finalizada con éxito.');
        } catch (\Exception $e) {
            Log::error('Error al finalizar inscripción: ' . $e->getMessage());
            return back()->withErrors(['error' => 'No se pudo finalizar la inscripción.']);
        }
    }

    // =================================================================
    // =========== MÉTODOS DE ACCIÓN PERSONALIZADOS (PATCH/GET) ========
    // =================================================================

    /**
     * Suspende la inscripción del alumno (PATCH admin.enrollments.suspend).
     * Esto detiene el conteo de días activos.
     *
     * @param  \App\Models\Enrollment  $enrollment
     * @return \Illuminate\Http\Response
     */
    public function suspend(Enrollment $enrollment)
    {
        // Solo suspender si está actualmente activo
        if ($enrollment->status !== 'active') {
            return back()->withErrors(['error' => 'Solo se pueden suspender inscripciones activas.']);
        }
        
        try {
            // Lógica de suspensión: Cambiar estado
            $enrollment->update(['status' => 'suspended']);

            // NOTA: Si necesitas guardar el tiempo restante (por ejemplo, en un campo 'remaining_days'),
            // la lógica para calcular y guardar ese valor iría aquí.

            return redirect()->route('admin.enrollments.index')
                             ->with('success', 'Inscripción suspendida correctamente.');

        } catch (\Exception $e) {
            Log::error('Error al suspender inscripción: ' . $e->getMessage());
            return back()->withErrors(['error' => 'No se pudo suspender la inscripción.']);
        }
    }

    /**
     * Reactiva una inscripción suspendida (PATCH admin.enrollments.reactivate).
     * Esto reanuda el conteo de días activos.
     *
     * @param  \App\Models\Enrollment  $enrollment
     * @return \Illuminate\Http\Response
     */
    public function reactivate(Enrollment $enrollment)
    {
        // Solo reactivar si está suspendido
        if ($enrollment->status !== 'suspended') {
            return back()->withErrors(['error' => 'Solo se pueden reactivar inscripciones suspendidas.']);
        }

        try {
            // Lógica de reactivación: Cambiar estado
            $enrollment->update(['status' => 'active']);

            // NOTA: Si guardaste días restantes, aquí podrías ajustar la end_date
            // sumándole los días que quedaron pendientes en el momento de la suspensión.

            return redirect()->route('admin.enrollments.index')
                             ->with('success', 'Inscripción reactivada correctamente.');

        } catch (\Exception $e) {
            Log::error('Error al reactivar inscripción: ' . $e->getMessage());
            return back()->withErrors(['error' => 'No se pudo reactivar la inscripción.']);
        }
    }

    /**
     * Prepara el formulario para renovar la inscripción (GET admin.enrollments.renew).
     * Normalmente, redirige a la vista de creación o a una vista de pago con datos pre-cargados.
     *
     * @param  \App\Models\Enrollment  $enrollment
     * @return \Illuminate\Http\Response
     */
    public function renew(Enrollment $enrollment)
    {
        // Lógica: La renovación es esencialmente una nueva inscripción.
        // Redirigimos al formulario 'create/index' pasando los datos del alumno 
        // y plan actual para que el proceso sea rápido.
        
        // NOTA: Para implementar la lógica de renovación en el formulario de creación:
        // 1. Necesitarías una vista separada 'renew' o una lógica más compleja en 'store'.
        // 2. Para simplificar, redirigimos, y la vista index puede usar `withInput` si fuera necesario.

        return redirect()->route('admin.enrollments.index')
                         ->withInput([
                             'student_profile_id' => $enrollment->student_profile_id,
                             'category_id' => $enrollment->category_id,
                             'plan_id' => $enrollment->plan_id,
                             'start_date' => now()->format('Y-m-d') // Nueva fecha de inicio
                         ])
                         ->with('info', 'Por favor, confirma los datos para la renovación del plan.');
    }
}