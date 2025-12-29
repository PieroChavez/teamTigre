<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Category;
use App\Models\Role;
use App\Models\CoachProfile;
use App\Models\StudentProfile;
use App\Models\Payment;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 1. Métricas de Usuarios
        $totalUsers     = User::count();
        $totalAdmins    = User::whereHas('role', fn($q) => $q->where('name', 'admin'))->count();
        $totalCoaches   = CoachProfile::count();
        $totalStudents  = StudentProfile::count();
        $totalCategories = Category::count();

        // 2. Cálculo de Ingresos Mensuales (Últimos 30 días)
        $monthlyRevenueValue = Payment::where('created_at', '>=', now()->subDays(30))
            ->sum('amount');
        
        // Formateamos el ingreso (Ej: S/ 1,200.00)
        $monthlyRevenue = 'S/ ' . number_format($monthlyRevenueValue, 2, '.', ',');

        // 3. Métricas de Inscripciones y Planes
        $activeEnrollmentsCount = Enrollment::where('status', 'active')->count();
        
        // Obtener el plan más popular (opcional, lógica básica)
        $topPlan = Payment::select('plan_id', \DB::raw('count(*) as total'))
            ->groupBy('plan_id')
            ->with('plan')
            ->orderBy('total', 'desc')
            ->first();

        $topPlanName = $topPlan ? $topPlan->plan->name : 'N/A';
        $topPlanCount = $topPlan ? $topPlan->total : 0;
        
        // Pagos vencidos (Lógica básica: inscripciones activas sin pagos recientes)
        $pastDueCount = 0; // Aquí podrías implementar una lógica de fechas de vencimiento

        return view('dashboards.admin', compact(
            'totalUsers',
            'totalAdmins',
            'totalCoaches',
            'totalStudents',
            'totalCategories',
            'monthlyRevenue',
            'activeEnrollmentsCount',
            'topPlanName',
            'topPlanCount',
            'pastDueCount'
        ));
    }

    /**
     * Muestra la lista general de pagos realizados.
     */
    public function paymentsIndex()
    {
        $payments = Payment::with([
                'plan', 
                'enrollment' => function ($query) {
                    $query->with([
                        'category',
                        'studentProfile.user'
                    ]);
                }
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Muestra el formulario para registrar un nuevo pago de un alumno específico.
     */
    public function createPayment(StudentProfile $studentProfile)
    {
        $enrollments = $studentProfile->enrollments()
                                     ->where('status', 'active')
                                     ->with('category', 'plan')
                                     ->get();

        $studentProfile->load('user');

        return view('admin.payments.create', compact('studentProfile', 'enrollments'));
    }

    /**
     * Procesa y guarda un nuevo pago en la base de datos.
     */
    public function storePayment(Request $request)
    {
        $request->validate([
            'enrollment_id' => 'required|exists:enrollments,id',
            'amount' => 'required|numeric|min:0.01',
            'method' => 'required|in:cash,yape,transfer',
            'paid_at' => 'required|date',
            'notes' => 'nullable|string|max:500',
        ]);
        
        $enrollment = Enrollment::find($request->enrollment_id);

        if (!$enrollment) {
            return back()->with('error', 'La inscripción seleccionada no es válida.');
        }

        Payment::create([
            'enrollment_id' => $enrollment->id,
            'plan_id'       => $enrollment->plan_id,
            'amount'        => $request->amount,
            'method'        => $request->method,
            'status'        => 'paid',
            'paid_at'       => $request->paid_at,
            'notes'         => $request->notes,
        ]);

        return redirect()->route('admin.payments.index')->with('success', '¡Pago registrado exitosamente!');
    }

    /**
     * Muestra la vista de detalle de un alumno específico.
     */
    public function studentsShow(User $student)
    {
        if ($student->role->name !== 'alumno') {
            abort(404);
        }

        $student->load([
            'studentProfile',
            'studentProfile.enrollments.category',
            'studentProfile.enrollments.plan',
            'studentProfile.enrollments.payments' => function ($query) {
                $query->orderBy('created_at', 'desc'); 
            }
        ]);

        return view('admin.students.show', compact('student'));
    }
}