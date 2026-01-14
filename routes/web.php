<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProfileController,
    DashboardController,
    AlumnoController,
    DocenteController,
    CategoriaController,
    PlantillaPeriodoController,
    HorarioController,
    InscripcionController,
    AsistenciaController,
    CuentaInscripcionController,
    CuotaPagoController,
    TipoPagoController,
    PagoController,
    VentaController,
    DetalleVentaController,
    CategoriaProductoController,
    ProductoController, 
    NoticiaController,
    EventoController,
    PeleadorController,
    BoletoController,
};

use App\Http\Controllers\Tienda\PublicProductoController as PublicController;
use App\Http\Controllers\Tienda\CarritoController;
use App\Http\Controllers\Tienda\PedidoController;

/*
|--------------------------------------------------------------------------
| 🌐 WEB PÚBLICA
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('public.home');
})->name('home');

// --- 🛒 TIENDA PÚBLICA ---
Route::get('/tienda', [PublicController::class, 'index'])->name('tienda.index');
Route::get('/tienda/producto/{producto}', [PublicController::class, 'show'])->name('tienda.show');

// --- 🛍️ CARRITO ---
Route::controller(CarritoController::class)->group(function () {
    Route::get('/carrito', 'index')->name('carrito.index');
    Route::post('/carrito/agregar/{id}', 'agregar')->name('carrito.agregar');
    Route::delete('/carrito/eliminar/{id}', 'eliminar')->name('carrito.eliminar');
});

// --- 📦 CHECKOUT / PEDIDOS ---
Route::controller(PedidoController::class)->group(function () {
    Route::get('/finalizar-compra', 'checkout')->name('tienda.checkout');
    Route::post('/confirmar-pedido', 'confirmar')->name('tienda.confirmar');
});

/*
|--------------------------------------------------------------------------
| 🔐 RUTAS PROTEGIDAS (Requieren Login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // 🔴 PERFIL DE USUARIO
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    /*
    |----------------------------------------------------------------------
    | 🔐 ROL: ADMINISTRADOR
    |----------------------------------------------------------------------
    */
    Route::middleware('role:Admin')->group(function () {
        
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // --- 🥊 GESTIÓN ACADÉMICA ---
        Route::resource('alumnos', AlumnoController::class);
        Route::resource('docentes', DocenteController::class);
        Route::resource('categorias', CategoriaController::class);
        Route::resource('periodos', PlantillaPeriodoController::class);
        Route::resource('inscripciones', InscripcionController::class);
        Route::resource('cuentas', CuentaInscripcionController::class);
        
        // --- 📅 HORARIOS ---
        Route::resource('horarios', HorarioController::class);
        Route::controller(HorarioController::class)->group(function () {
            Route::get('horarios/grupo/{grupo_key}/edit', 'editGroup')->name('horarios.editGroup');
            Route::put('horarios/grupo/{grupo_key}', 'updateGroup')->name('horarios.updateGroup');
            Route::delete('horarios/grupo/{grupo_key}', 'destroyGroup')->name('horarios.destroyGroup');
        });

        // --- 💰 FINANZAS ---
        // 1. Crear cuota extra para el alumno (Formulario y Guardado)
        Route::get('cuotas/crear-para-alumno/{alumno}', [CuotaPagoController::class, 'createForAlumno'])
            ->name('cuotas.createForAlumno');
        
        // --- LÍNEA AÑADIDA PARA SOLUCIONAR EL ERROR ---
        Route::post('cuotas/store-for-alumno/{alumno}', [CuotaPagoController::class, 'storeForAlumno'])
            ->name('cuotas.storeForAlumno');

        // 2. CORRECCIÓN: Registrar pago desde el formulario de Alumnos
        Route::post('alumnos/{alumno}/registrar-pago', [PagoController::class, 'store'])
            ->name('alumnos.registrarPago');
            
        Route::resource('cuotas', CuotaPagoController::class);
        Route::resource('tipos_pago', TipoPagoController::class);
        Route::resource('pagos', PagoController::class);

        // --- 🏪 TIENDA E INVENTARIO ---
        Route::resource('productos', ProductoController::class); 
        Route::resource('categorias-productos', CategoriaProductoController::class);
        Route::resource('ventas', VentaController::class);
        Route::resource('detalle-ventas', DetalleVentaController::class);

        // --- 📰 CONTENIDO Y MARKETING ---
        Route::resource('noticias', NoticiaController::class);
        Route::resource('eventos', EventoController::class);
        Route::resource('peleadores', PeleadorController::class);
        Route::resource('boletos', BoletoController::class);
    });

    /*
    |----------------------------------------------------------------------
    | 💰 ROL: VENTAS
    |----------------------------------------------------------------------
    */
    Route::middleware('role:Ventas')->group(function () {
        Route::resource('ventas', VentaController::class)->only(['index', 'store', 'show']);
    });

    /*
    |----------------------------------------------------------------------
    | 🎓 ROL: ALUMNO / ESTUDIANTE
    |----------------------------------------------------------------------
    */
    Route::middleware('role:Alumno,Estudiante')->group(function () {
        Route::get('alumnos/{alumno}/perfil', [AlumnoController::class, 'perfil'])->name('alumnos.perfil');
        Route::get('alumnos/{alumno}/asistencias', [AsistenciaController::class, 'index'])->name('alumnos.asistencias');
        Route::get('cuotas/{cuotaPago}/recibo', [CuotaPagoController::class, 'verRecibo'])->name('cuotas.recibo');
    });

    // --- 📄 DOCUMENTOS Y REPORTES ---
    Route::get('inscripciones/{alumno}/imprimir-ficha', [InscripcionController::class, 'imprimirFicha'])->name('inscripciones.imprimirFicha');
    Route::get('pagos/{pago}/recibo-pdf', [PagoController::class, 'imprimirRecibo'])->name('pagos.imprimir_recibo');

});

require __DIR__.'/auth.php';