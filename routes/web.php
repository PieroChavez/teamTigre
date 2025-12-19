<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\EventoAlumnoController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\Admin\UserController; 


Route::get('/', [WebController::class, 'home'])->name('web.home');
Route::get('/informacion', [WebController::class, 'informacion'])->name('web.informacion');

Route::get('/login', function () {
    return redirect()->route('login');
})->name('web.login');



Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('web/noticias', [NoticiaController::class, 'web'])
    ->name('web.noticias');
Route::get('web/noticias/{noticia}', [NoticiaController::class, 'show'])
    ->name('web.noticia');
Route::get('web/eventos', [EventoController::class, 'web'])
    ->name('web.eventos');
Route::get('web/eventos/{evento}', [EventoController::class, 'showWeb'])
    ->name('web.evento');



Route::middleware(['auth'])->group(function () {
    
   
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard'); 


    Route::resource('users', UserController::class)
        ->names('admin.users')
        ->except(['show']); 

  
    Route::resource('alumnos', AlumnoController::class);

  
    Route::get('asistencias', [AsistenciaController::class, 'index'])
        ->name('asistencias.index');
    Route::post('asistencias', [AsistenciaController::class, 'store'])
        ->name('asistencias.store');
    Route::get('alumnos/{alumno}/asistencias',
        [AsistenciaController::class, 'historial']
    )->name('alumnos.asistencias');

  
    Route::get('alumnos/{alumno}/pagos', [PagoController::class, 'index'])
        ->name('alumnos.pagos');
    Route::post('alumnos/{alumno}/pagos', [PagoController::class, 'store'])
        ->name('alumnos.pagos.store');
    Route::get('pagos/{pago}/edit', [PagoController::class, 'edit'])
        ->name('pagos.edit');
    Route::put('pagos/{pago}', [PagoController::class, 'update'])
        ->name('pagos.update');
    Route::delete('pagos/{pago}', [PagoController::class, 'destroy'])
        ->name('pagos.destroy');
 
    Route::get('eventos/{evento}/pagos', 
        [PagoController::class, 'showEventPayments']
    )->name('eventos.pagos'); 


    Route::resource('eventos', EventoController::class)
        ->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);
    Route::get('eventos/{evento}/alumnos',
        [EventoAlumnoController::class, 'create']
    )->name('eventos.alumnos');
    Route::post('eventos/{evento}/alumnos',
        [EventoAlumnoController::class, 'store']
    )->name('eventos.alumnos.store');

    Route::get('eventos/{evento}/inscribir', [EventoController::class, 'inscribir'])
        ->name('eventos.inscribir');
    Route::post('eventos/{evento}/inscribir', [EventoController::class, 'guardarInscripcion'])
        ->name('eventos.inscribir.guardar');


    Route::resource('noticias', NoticiaController::class)
        ->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);
});