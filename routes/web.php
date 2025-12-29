<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Models\Plan; 
use App\Models\Category; 

use App\Http\Controllers\PublicPagesController; 

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\EnrollmentController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\CoachController as AdminCoachController;
use App\Http\Controllers\Admin\PaymentController; 
use App\Http\Controllers\Admin\PlanController; 

use App\Http\Controllers\Coach\DashboardController as CoachDashboardController;
use App\Http\Controllers\Coach\AttendanceController;

use App\Http\Controllers\AlumnoController; 
use App\Http\Controllers\StudentEnrollmentController; 

Route::get('/', function () {
    $plans = Plan::where('active', true)->get();
    return view('welcome', compact('plans'));
})->name('welcome');

Route::get('/clases', function () {
    $categories = Category::withCount('coaches')->get();
    return view('clases', compact('categories'));
})->name('clases'); 

Route::view('/eventos', 'eventos')->name('eventos'); 

Route::get('/planes', function () {
    $plans = Plan::where('active', true)->get();
    return view('planes', compact('plans')); 
})->name('planes');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->get('/redirect', function () {
    $user = auth()->user();

    if (!$user->role) {
        return redirect()->route('welcome'); 
    }

    return match ($user->role->name) {
        'admin'  => redirect()->route('admin.dashboard'),
        'coach'  => redirect()->route('coach.dashboard'),
        'alumno' => redirect()->route('student.dashboard'), 
        default  => abort(403),
    };
})->name('redirect.by.role');

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        Route::resource('students', StudentController::class)->except(['destroy']);
        Route::post('students/{student}/deactivate', [StudentController::class, 'deactivate'])
            ->name('students.deactivate');
            
        Route::resource('coaches', AdminCoachController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('enrollments', EnrollmentController::class);
        Route::resource('plans', PlanController::class)->except(['show']); 
        Route::resource('payments', PaymentController::class);

        Route::get('students/{student}/edit-photo', [StudentController::class, 'editPhoto'])
            ->name('students.edit-photo');
        Route::put('students/{student}/update-photo', [StudentController::class, 'updatePhoto'])
            ->name('students.update-photo');

        Route::patch('enrollments/{enrollment}/suspend', [EnrollmentController::class, 'suspend'])->name('enrollments.suspend');
        Route::patch('enrollments/{enrollment}/reactivate', [EnrollmentController::class, 'reactivate'])->name('enrollments.reactivate');
        Route::get('enrollments/{enrollment}/renew', [EnrollmentController::class, 'renew'])->name('enrollments.renew');

        Route::get('categories/{category}/coaches', [CategoryController::class, 'editCoaches'])->name('categories.coaches.edit');
        Route::put('categories/{category}/coaches', [CategoryController::class, 'updateCoaches'])->name('categories.coaches.update');
    });

Route::middleware(['auth', 'role:coach'])
    ->prefix('coach')
    ->name('coach.')
    ->group(function () {
        Route::get('/dashboard', [CoachDashboardController::class, 'index'])->name('dashboard');
        
        Route::get('categories/{category}/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
        Route::post('categories/{category}/attendance', [AttendanceController::class, 'store'])->name('attendance.store');

        Route::get('categories/{category}/attendance/history', [AttendanceController::class, 'history'])
            ->name('attendance.history');
    });

Route::middleware(['auth', 'role:alumno'])
    ->prefix('alumno') 
    ->name('student.') 
    ->group(function () {
        
        Route::get('/dashboard', [AlumnoController::class, 'dashboard'])
            ->name('dashboard');

        Route::get('/mis-inscripciones', [StudentEnrollmentController::class, 'index'])
            ->name('enrollments.index');

        Route::get('/mis-asistencias', [AlumnoController::class, 'attendanceHistory'])
             ->name('attendance.history');

        Route::get('/mis-pagos', [AlumnoController::class, 'paymentHistory'])
            ->name('payments.history');
    });

require __DIR__.'/auth.php';