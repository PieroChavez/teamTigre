<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Mostrar formulario de asistencia por categoría (Toma de asistencia hoy)
     */
    public function index(Category $category)
    {
        $today = now()->toDateString();

        // Obtenemos inscripciones activas con sus perfiles y nombres de usuario
        $enrollments = $category->enrollments()
            ->with(['studentProfile.user'])
            ->where('status', 'active')
            ->get();

        return view('coach.attendance.index', compact(
            'category',
            'enrollments',
            'today'
        ));
    }

    /**
     * Guardar o actualizar la asistencia diaria
     */
    public function store(Request $request, Category $category)
    {
        $request->validate([
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'in:present,absent', 
        ]);

        foreach ($request->attendance as $enrollmentId => $status) {
            Attendance::updateOrCreate(
                [
                    'enrollment_id' => $enrollmentId,
                    'date'          => $request->date,
                ],
                [
                    'status'        => $status,
                ]
            );
        }

        return redirect()->route('coach.attendance.index', $category)
            ->with('success', 'La asistencia para la categoría "' . $category->name . '" ha sido guardada correctamente.');
    }

    /**
     * Muestra el historial de asistencia por categoría.
     * Genera una matriz de fechas y estados para los alumnos.
     */
    public function history(Category $category)
    {
        // 1. Obtener las inscripciones activas de la categoría
        $enrollments = $category->enrollments()
            ->with(['studentProfile.user'])
            ->where('status', 'active')
            ->get();
        
        // 2. Obtener los registros de asistencia de los últimos 30 días
        // Agrupamos por fecha para que en la vista sea fácil buscar: $recentAttendances['2023-10-25']
        $recentAttendances = Attendance::whereIn('enrollment_id', $enrollments->pluck('id'))
            ->where('date', '>=', now()->subDays(30))
            ->orderBy('date', 'desc')
            ->get()
            ->groupBy('date'); 

        // 3. Generar un rango de fechas (últimos 7 días) para los encabezados de la tabla
        $dateRange = collect(range(0, 6))->map(function ($day) {
            return now()->subDays($day)->toDateString();
        })->reverse(); 

        return view('coach.attendance.history', compact(
            'category',
            'enrollments',
            'recentAttendances',
            'dateRange'
        ));
    }
}