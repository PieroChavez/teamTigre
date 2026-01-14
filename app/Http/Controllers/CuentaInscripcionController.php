<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CuentaInscripcion; // Modelo de cuentas
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\RelationNotFoundException; // Importar excepción específica

class CuentaInscripcionController extends Controller
{
    /**
     * Muestra la lista de cuentas (Estado financiero general).
     */
    public function index()
    {
        try {
            // Precargamos relaciones importantes para evitar N+1
            $cuentas = CuentaInscripcion::with([
                'inscripcion.alumno.user', // Alumno y usuario
                'conceptoPago'             // Concepto de la cuenta
            ])->paginate(15); // Paginación estándar
            
            return view('cuentas.index', compact('cuentas'));
            
        } catch (RelationNotFoundException $e) {
             // Si falta una relación clave en el index
             \Log::error("Error de relación en Cuentas INDEX: " . $e->getMessage());
             return redirect()->back()->with('error', 'Error crítico: Falta una relación en el modelo CuentaInscripcion (Index).');
        } catch (\Exception $e) {
            // Manejo genérico para otros errores de BD o lógica
            return view('cuentas.index', [
                'cuentas' => collect([]),
                'error' => 'No se pudieron cargar los datos de la lista. Verifique la conexión o las relaciones.'
            ]);
        }
    }

    /**
     * Muestra el detalle de una cuenta específica.
     */
    public function show(CuentaInscripcion $cuentaInscripcion)
    {
        try {
            // Precargamos todas las relaciones necesarias para la vista de detalle
            $cuenta = $cuentaInscripcion->load([
                'inscripcion.alumno.user',
                'conceptoPago',
                'cuotaPagos.pagos.tipoPago',     
                'cuotaPagos.pagos.usuario'       
            ]);

            return view('cuentas.show', compact('cuenta'));

        } catch (RelationNotFoundException $e) {
            // ⭐ CORRECCIÓN: Quitamos el método getRelation() y usamos el mensaje completo.
            \Log::error("Error de relación en Cuentas SHOW: " . $e->getMessage());
            return redirect()->route('cuentas.index')->with('error', 
                'Error de Relación: ' . $e->getMessage() . '. Por favor, revise su modelo CuentaInscripcion.'
            );
        } catch (\Exception $e) {
            return redirect()->route('cuentas.index')->with('error', 
                'Error desconocido al cargar el detalle: ' . $e->getMessage()
            );
        }
    }
    /**
     * Mostrar formulario para crear nueva cuenta (vacío por ahora)
     */
    public function create() { /* ... */ }

    /**
     * Guardar nueva cuenta (vacío por ahora)
     */
    public function store(Request $request) { /* ... */ }

    /**
     * Mostrar formulario para editar cuenta existente (vacío por ahora)
     */
    public function edit(string $id) { /* ... */ }

    /**
     * Actualizar cuenta existente (vacío por ahora)
     */
    public function update(Request $request, string $id) { /* ... */ }

    /**
     * Eliminar cuenta existente (vacío por ahora)
     */
    public function destroy(string $id) { /* ... */ }
}