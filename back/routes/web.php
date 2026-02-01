<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\EnrollmentController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductCategoryController;
use App\Http\Controllers\Api\StoreOrderController;
use App\Http\Controllers\Api\AttendanceController;

Route::prefix('api')->middleware(['api'])->group(function () {

    // ✅ Manejo de CORS Preflight
    Route::options('/{any}', fn () => response()->noContent(204))->where('any', '.*');

    // Health Check
    Route::get('/health', fn () => response()->json(['status' => 'ok', 'server' => 'Laravel 12']));

    // ================= TIENDA PÚBLICA =================
    Route::get('/product-categories', [ProductCategoryController::class, 'index']);
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{slug}', [ProductController::class, 'show']);
    Route::post('/store/orders', [StoreOrderController::class, 'storePublic']);

    // ================= AUTH PÚBLICO =================
    Route::post('/auth/login', [AuthController::class, 'login']);

    // ================= PROTEGIDO (Sanctum) =================
    Route::middleware('auth:sanctum')->group(function () {

        // Perfil y Logout
        Route::get('/auth/me', [AuthController::class, 'me']);
        Route::post('/auth/logout', [AuthController::class, 'logout']);

        // ✅ GESTIÓN DE ASISTENCIA (Admin y Controlador)
        Route::middleware(['role:attendance_controller|admin'])->group(function () {
            Route::post('/attendance/scan', [AttendanceController::class, 'scan']);
            Route::get('/attendance/today', [AttendanceController::class, 'today']); 
            Route::get('/attendance/history', [AttendanceController::class, 'history']);
        });

        // ✅ ACADEMIA
        Route::apiResource('students', StudentController::class);
        Route::apiResource('categories', CategoryController::class);
        Route::apiResource('enrollments', EnrollmentController::class);
        
        // Acciones especiales de estudiantes
        Route::post('/students/{student}/create-user', [StudentController::class, 'createUser']);

        // ✅ TIENDA (Gestión Admin)
        Route::apiResource('products', ProductController::class)->except(['index', 'show']);
        
        // Categorías de productos
        Route::apiResource('product-categories', ProductCategoryController::class)->only(['store', 'update', 'destroy']);

        // Gestión de Pedidos de Tienda
        Route::get('/store/orders', [StoreOrderController::class, 'index']);
        Route::get('/store/orders/{storeOrder}', [StoreOrderController::class, 'show']);
        Route::put('/store/orders/{storeOrder}', [StoreOrderController::class, 'update']);

        // ✅ PAGOS Y CRÉDITOS (Enrollments)
        Route::prefix('enrollments/{enrollment}')->group(function () {
            Route::post('/credit', [EnrollmentController::class, 'saveCredit']);
            Route::get('/initial-payment', [EnrollmentController::class, 'getInitialPayment']);
            Route::post('/initial-payment', [EnrollmentController::class, 'saveInitialPayment']);
            Route::get('/installments', [EnrollmentController::class, 'installments']);
        });

        Route::post('/installments/{installment}/pay', [EnrollmentController::class, 'payInstallment']);
    });
});

// ================= RUTAS DE VISTA (SPA) =================
// Esta ruta carga el HTML de React para el módulo de escaneo
Route::middleware(['auth:sanctum', 'role:attendance_controller|admin'])->group(function () {
    Route::get('/attendance', fn () => view('app')); 
});

// Fallback para rutas inexistentes
Route::fallback(fn () => response()->json(['message' => 'Resource not found.'], 404));