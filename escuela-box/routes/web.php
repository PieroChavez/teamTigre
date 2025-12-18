<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\EventoAlumnoController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\WebController;

Route::get('/', function () {
    return view('welcome');
});

/* =====================
   ALUMNOS
===================== */
Route::resource('alumnos', AlumnoController::class);

/* =====================
   ASISTENCIAS
===================== */
Route::get('asistencias', [AsistenciaController::class, 'index'])
    ->name('asistencias.index');

Route::post('asistencias', [AsistenciaController::class, 'store'])
    ->name('asistencias.store');

Route::get('alumnos/{alumno}/asistencias',
    [AsistenciaController::class, 'historial']
)->name('alumnos.asistencias');

/* =====================
   PAGOS POR ALUMNO
===================== */
Route::get('alumnos/{alumno}/pagos', [PagoController::class, 'index'])
    ->name('alumnos.pagos');

Route::post('alumnos/{alumno}/pagos', [PagoController::class, 'store'])
    ->name('alumnos.pagos.store');

/* =====================
   PAGOS - EDITAR / ELIMINAR
===================== */
Route::get('pagos/{pago}/edit', [PagoController::class, 'edit'])
    ->name('pagos.edit');

Route::put('pagos/{pago}', [PagoController::class, 'update'])
    ->name('pagos.update');

Route::delete('pagos/{pago}', [PagoController::class, 'destroy'])
    ->name('pagos.destroy');


/* =====================
   EVENTOS
===================== */
Route::resource('eventos', EventoController::class)
    ->only(['index', 'create', 'store']);

Route::get('eventos/{evento}/alumnos',
    [EventoAlumnoController::class, 'create']
)->name('eventos.alumnos');

Route::post('eventos/{evento}/alumnos',
    [EventoAlumnoController::class, 'store']
)->name('eventos.alumnos.store');

// >>>>> RUTA AÑADIDA PARA SOLUCIONAR EL ERROR event os.pagos <<<<<
Route::get('eventos/{evento}/pagos', 
    [PagoController::class, 'showEventPayments']
)->name('eventos.pagos'); 
// >>>>> FIN DE RUTA AÑADIDA <<<<<

/* =====================
   NOTICIAS (ADMIN)
===================== */
Route::resource('noticias', NoticiaController::class)
    ->only(['index', 'create', 'store']);

/* =====================
   WEB PÚBLICA
===================== */
Route::get('web/noticias', [NoticiaController::class, 'web'])
    ->name('web.noticias');

Route::get('web/noticias/{noticia}', [NoticiaController::class, 'show'])
    ->name('web.noticia');

Route::get('web/eventos', [EventoController::class, 'web'])
    ->name('web.eventos');

Route::get('web/eventos/{evento}', [EventoController::class, 'showWeb'])
    ->name('web.evento');

/* =====================
   INSCRIPCIÓN EVENTOS
===================== */
Route::get('eventos/{evento}/inscribir', [EventoController::class, 'inscribir'])
    ->name('eventos.inscribir');

Route::post('eventos/{evento}/inscribir', [EventoController::class, 'guardarInscripcion'])
    ->name('eventos.inscribir.guardar');


Route::get('/', [WebController::class, 'home'])->name('web.home');
Route::get('/informacion', [WebController::class, 'informacion'])->name('web.informacion');
Route::get('/login', function () {
    return redirect()->route('login'); // o tu ruta de login si usas Laravel Breeze/Jetstream
})->name('web.login');