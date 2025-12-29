<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use App\Models\User;
use App\Models\Enrollment; 
use App\Models\Attendance;
use App\Models\Payment; 

class AlumnoController extends Controller
{
    public function dashboard()
    {
        $alumno = Auth::user(); 
        $profile = $alumno->studentProfile;
        $enrollments = collect(); 
        
        if ($profile) {
            $enrollments = $profile->enrollments()
                ->where('status', 'active') 
                ->with('category', 'plan') 
                ->get();
        }

        return view('dashboards.alumno', compact('alumno', 'profile', 'enrollments'));
    }

    public function enrollmentIndex()
    {
        $alumno = Auth::user();
        $profile = $alumno->studentProfile;

        if (!$profile) {
            $enrollments = collect();
        } else {
            $enrollments = $profile->enrollments()
                ->with('category', 'plan')
                ->orderByDesc('start_date')
                ->get();
        }
                                                
        return view('student.enrollments.index', compact('alumno', 'enrollments'));
    }

    public function attendanceHistory()
    {
        $user = Auth::user();
        
        if (!$user->studentProfile) {
            abort(404, 'Perfil de estudiante no encontrado.');
        }

        $studentProfileId = $user->studentProfile->id;

        $enrollments = Enrollment::where('student_profile_id', $studentProfileId)
            ->whereIn('status', ['active', 'finished', 'suspended']) 
            ->with('category') 
            ->orderByDesc('start_date')
            ->get();
        
        $enrollmentIds = $enrollments->pluck('id');

        $attendances = Attendance::whereIn('enrollment_id', $enrollmentIds)
            ->orderBy('date', 'desc')
            ->get();

        $historyByEnrollment = $attendances->groupBy('enrollment_id');

        return view('student.attendance.history', compact(
            'enrollments', 
            'historyByEnrollment' 
        ));
    }

    public function paymentHistory()
    {
        $user = Auth::user();
        
        if (!$user->studentProfile) {
            $payments = collect();
            return view('student.payments.history', compact('payments'));
        }

        $studentProfileId = $user->studentProfile->id;
        
        $enrollmentIds = Enrollment::where('student_profile_id', $studentProfileId)
            ->pluck('id');

        $payments = Payment::whereIn('enrollment_id', $enrollmentIds)
            ->with(['enrollment.category', 'plan']) 
            ->orderBy('created_at', 'desc')
            ->get();

        return view('student.payments.history', compact('payments'));
    }

    public function index()
    {
        $alumnos = User::with('studentProfile')
            ->whereHas('role', function ($q) {
                $q->where('name', 'alumno');
            })
            ->get();

        return view('alumnos.index', compact('alumnos'));
    }
}