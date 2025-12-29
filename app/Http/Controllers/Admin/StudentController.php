<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\StudentProfile;
use App\Models\Payment;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage; 
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;

class StudentController extends Controller
{
    private $genderMapping = [
        'masculino' => 'male',
        'femenino' => 'female',
        'otro' => 'other',
    ];

    private $statusMapping = [
        'activo' => 'active',
        'inactivo' => 'inactive',
        'suspendido' => 'inactive',
    ];

    public function index()
    {
        $students = User::with([
                'studentProfile', 
                'studentProfile.enrollments.category'
            ])
            ->whereHas('role', fn($q) => $q->where('name', 'alumno'))
            ->orderBy('name')
            ->paginate(10);

        return view('admin.students.index', compact('students'));
    }

    public function show(User $student)
    {
        if ($student->role->name !== 'alumno') {
            abort(404, 'Usuario no es un alumno.');
        }

        $student->load([
            'studentProfile',
            'studentProfile.enrollments.category',
            'studentProfile.enrollments.plan',
            'studentProfile.enrollments.payments' => fn($q) => $q->orderBy('created_at', 'desc')
        ]);

        return view('admin.students.show', compact('student'));
    }

    public function create()
    {
        $statuses = ['activo', 'inactivo', 'suspendido'];
        $genders = ['masculino', 'femenino', 'otro'];

        return view('admin.students.create', compact('statuses', 'genders'));
    }

    public function store(StoreStudentRequest $request)
    {
        $studentRole = Role::where('name', 'alumno')->firstOrFail();
        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $studentRole->id,
            ]);

            $studentCode = $request->code ?: 'AL-' . time();

            $user->studentProfile()->create([
                'dni' => $request->dni,
                'code' => $studentCode,
                'phone' => $request->phone,
                'birth_date' => $request->birth_date,
                'gender' => $this->genderMapping[$request->gender] ?? null,
                'emergency_contact' => $request->emergency_contact,
                'notes' => $request->notes,
                'joined_at' => now(),
                'status' => $this->statusMapping[$request->status] ?? 'inactive',
            ]);

            DB::commit();

            return redirect()
                ->route('admin.students.index')
                ->with('success', "Alumno creado correctamente. Código: $studentCode");

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear alumno: ' . $e->getMessage());

            return back()->withInput()
                         ->withErrors(['critical_error' => 'No se pudo crear el alumno: ' . $e->getMessage()]);
        }
    }

    public function edit(User $student)
    {
        $student->load('studentProfile');
        $statuses = ['activo', 'inactivo', 'suspendido'];
        $genders = ['masculino', 'femenino', 'otro'];

        return view('admin.students.edit', compact('student', 'statuses', 'genders'));
    }

    public function update(UpdateStudentRequest $request, User $student)
    {
        DB::beginTransaction();
        try {
            $student->update(['name' => $request->name, 'email' => $request->email]);
            if ($request->filled('password')) {
                $student->update(['password' => Hash::make($request->password)]);
            }

            $student->studentProfile()->updateOrCreate(
                ['user_id' => $student->id],
                [
                    'dni' => $request->dni,
                    'code' => $request->code,
                    'phone' => $request->phone,
                    'birth_date' => $request->birth_date,
                    'gender' => $this->genderMapping[$request->gender] ?? null,
                    'emergency_contact' => $request->emergency_contact,
                    'notes' => $request->notes,
                    'status' => $this->statusMapping[$request->status] ?? 'inactive',
                ]
            );

            DB::commit();
            return redirect()->route('admin.students.show', $student)
                             ->with('success', 'Alumno actualizado correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar alumno: ' . $e->getMessage());
            return back()->withInput()
                         ->withErrors(['critical_error' => 'Error al actualizar: ' . $e->getMessage()]);
        }
    }

    public function deactivate(User $student)
    {
        try {
            if ($student->studentProfile) {
                $student->studentProfile->update(['status' => 'inactive']);
                $message = 'Alumno desactivado correctamente.';
            } else {
                $message = 'El perfil del alumno no existe.';
            }
            return redirect()->route('admin.students.index')->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Error al desactivar alumno: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error al desactivar.']);
        }
    }

    public function createPayment(StudentProfile $studentProfile)
    {
        $enrollments = $studentProfile->enrollments()->where('status', 'active')->with('category', 'plan')->get();
        $studentProfile->load('user');

        return view('admin.payments.create', compact('studentProfile', 'enrollments'));
    }

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
            'plan_id' => $enrollment->plan_id,
            'amount' => $request->amount,
            'method' => $request->method,
            'status' => 'paid',
            'paid_at' => $request->paid_at,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.payments.index')->with('success', '¡Pago registrado exitosamente!');
    }

    public function editPhoto(User $student)
    {
        if (!$student->studentProfile) {
            abort(404, 'El alumno no tiene perfil.');
        }
        return view('admin.students.edit-photo', compact('student'));
    }

    public function updatePhoto(Request $request, User $student)
    {
        if (!$request->hasFile('photo')) {
            return back()->withErrors(['debug_error' => 'ERROR: El archivo "photo" no fue recibido por el servidor.']);
        }

        if (!$student->studentProfile) {
            return back()->withErrors(['error' => 'El perfil del alumno no existe, no se puede subir la foto.']);
        }

        $request->validate([
            'photo' => 'required|image|max:2048', 
        ]);
        
        $fileName = $request->file('photo')->getClientOriginalName();
        Log::info('DEBUG: Archivo recibido - ' . $fileName);
        
        $profile = $student->studentProfile;
        
        if ($profile->photo) {
            Storage::disk('public')->delete($profile->photo);
        }

        $path = $request->file('photo')->store('students', 'public');

        $profile->update(['photo' => $path]);

        return redirect()->route('admin.students.show', $student)
                         ->with('success', 'Fotografía actualizada correctamente.');
    }
}