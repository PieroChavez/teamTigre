<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentEnrollmentController extends Controller
{
    /**
     * Muestra el historial completo de inscripciones del alumno autenticado.
     * Esta vista es accesible desde el botón "Ver Historial Completo" del Dashboard.
     */
    public function index()
    {
        // 1. Obtener el usuario autenticado
        $user = Auth::user();

        // 2. Verificar si el usuario tiene un perfil de alumno asociado.
        // Esto previene errores si, por alguna razón, el perfil no existe.
        if (!$user->studentProfile) {
            // Si no hay perfil, redirigir al dashboard con un error.
            return redirect()->route('student.dashboard')->with('error', 'Tu perfil de estudiante no está completo o no está asociado correctamente.');
        }

        $studentProfileId = $user->studentProfile->id;

        // 3. Consultar TODAS las inscripciones (activas, suspendidas, finalizadas)
        // Se cargan las relaciones 'category' y 'plan' para mostrar sus nombres en la vista.
        $enrollments = Enrollment::where('student_profile_id', $studentProfileId)
            ->with(['category', 'plan'])
            ->orderBy('start_date', 'desc')
            ->get();

        // 4. Retornar la vista y pasar la colección de inscripciones.
        return view('student.enrollments.index', compact('enrollments'));
    }
}