<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CuotaPago; 
use App\Models\Alumno;
use App\Models\ConceptoPago;
use App\Models\CuentaInscripcion;
use App\Models\Pago;
use App\Models\TipoPago;
use Illuminate\Support\Facades\DB; 
use Illuminate\Validation\ValidationException;
use Barryvdh\DomPDF\Facade\Pdf; // <--- ¡IMPORTACIÓN AÑADIDA!

class CuotaPagoController extends Controller
{
    // Métodos CRUD básicos (vacíos o genéricos)
    public function index() {}
    public function store(Request $request) {}
    public function show(string $id) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}

    // =========================================================================
    // MÉTODOS PARA CREAR CUOTA MANUAL (EXTRA)
    // =========================================================================

    public function createForAlumno(Alumno $alumno)
    {
        $inscripcionesConCuenta = $alumno->inscripciones()
                                         ->where('estado', 'vigente')
                                         ->whereHas('cuentasInscripcion') 
                                         ->with(['categoria', 'periodo', 'cuentasInscripcion'])
                                         ->get();
        
        $conceptosPago = ConceptoPago::orderBy('nombre')->get();

        if ($inscripcionesConCuenta->isEmpty()) {
            return back()->with('error', '❌ El alumno no tiene una inscripción activa con una cuenta de deuda asociada para registrar cuotas manuales.');
        }

        return view('cuotas.create_manual', compact('alumno', 'inscripcionesConCuenta', 'conceptosPago'));
    }

    public function storeForAlumno(Request $request, Alumno $alumno)
    {
        $request->validate([
            'inscripcion_id' => ['required', 'exists:inscripciones,id'],
            'concepto_pago_id' => ['required', 'exists:conceptos_pago,id'], 
            'monto' => ['required', 'numeric', 'min:0.01'],
            'fecha_programada' => ['nullable', 'date'], 
        ]);

        $inscripcion = $alumno->inscripciones()->with('categoria')->findOrFail($request->inscripcion_id);
        $cuentaInscripcion = $inscripcion->cuentasInscripcion()->first();
        
        if (!$cuentaInscripcion) {
            throw ValidationException::withMessages(['inscripcion_id' => 'La inscripción seleccionada no tiene una cuenta de deuda activa.']);
        }

        $conceptoPago = ConceptoPago::find($request->concepto_pago_id);
        $tipoPagoPorDefectoId = 1; 

        try {
            DB::transaction(function () use ($cuentaInscripcion, $request, $inscripcion, $conceptoPago, $tipoPagoPorDefectoId) {
                
                CuotaPago::create([
                    'cuenta_inscripcion_id' => $cuentaInscripcion->id,
                    'tipo_pago_id' => $tipoPagoPorDefectoId,
                    'concepto_pago_id' => $request->concepto_pago_id,
                    'concepto' => $inscripcion->categoria->nombre . ' - Cuota Extra: ' . $conceptoPago->nombre, 
                    'monto' => $request->monto,
                    'monto_pagado' => 0.00,
                    'fecha_programada' => $request->fecha_programada ?? now()->addDays(7), 
                    'estado' => 'pendiente',
                ]);

            });
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Error al crear cuota manual: " . $e->getMessage());
             return back()->withInput()->with('error', 'Error al registrar la cuota manual: ' . $e->getMessage());
        }


        return redirect()->route('alumnos.show', $alumno->id)
                         ->with('success', '✅ ¡Cuota extra "' . $conceptoPago->nombre . '" de $' . number_format($request->monto, 2) . ' registrada con éxito!');
    }

    // =========================================================================
    // MÉTODOS PARA REGISTRAR PAGO CONTRA UNA CUOTA ESPECÍFICA
    // =========================================================================
    
    public function createPago(CuotaPago $cuota)
    {
        if ($cuota->estado === 'pagado') {
            // Esta línea funciona si la cuentaInscripcion tiene un alumno_id o si se puede acceder a él de otra forma
            return redirect()->route('alumnos.show', $cuota->cuentaInscripcion->alumno_id)
                             ->with('error', '✅ La cuota seleccionada ya está totalmente saldada.');
        }

        // CORRECCIÓN 1: Se carga la relación completa 'inscripcion.alumno.user'
        $cuota->load('cuentaInscripcion.inscripcion.alumno.user'); // <<-- CORRECCIÓN APLICADA
        
        $tiposPago = TipoPago::orderBy('nombre')->get();
        $montoPendiente = $cuota->monto - $cuota->monto_pagado; 

        return view('cuotas.pagar', compact('cuota', 'tiposPago', 'montoPendiente'));
    }

    public function storePago(Request $request, CuotaPago $cuota)
    {
        $montoPendiente = $cuota->monto - $cuota->monto_pagado + 0.01; 

        $request->validate([
            'monto' => ['required', 'numeric', 'min:0.01', 'max:' . $montoPendiente],
            'tipo_pago_id' => ['required', 'exists:tipos_pago,id'],
            'referencia' => ['nullable', 'string', 'max:255'],
        ]);

        $montoPagadoAhora = (float) $request->monto;
        $nuevoMontoPagado = $cuota->monto_pagado + $montoPagadoAhora;
        
        $esPagoCompleto = $nuevoMontoPagado >= $cuota->monto - 0.01; 
        
        $tipoPago = TipoPago::findOrFail($request->tipo_pago_id);
        
        DB::transaction(function () use ($cuota, $request, $montoPagadoAhora, $nuevoMontoPagado, $esPagoCompleto, $tipoPago) {
            
            Pago::create([
                'cuota_pago_id' => $cuota->id,
                'tipo_pago_id' => $request->tipo_pago_id,
                'monto' => $montoPagadoAhora,
                'fecha_pago' => now(),
                'referencia' => $request->referencia,
                'usuario_id' => auth()->id(), 
                'metodo' => $tipoPago->nombre, // Asumiendo que el campo requerido es 'metodo'
            ]);

            $cuota->monto_pagado = $nuevoMontoPagado;
            $cuota->estado = $esPagoCompleto ? 'pagado' : 'parcial';
            
            if ($esPagoCompleto && empty($cuota->fecha_pago)) {
                 $cuota->fecha_pago = now(); 
            }
            
            $cuota->save();
            
            $cuenta = $cuota->cuentaInscripcion;
            $cuotasPendientes = $cuenta->cuotas()->where('estado', '!=', 'pagado')->count();
            if ($cuotasPendientes === 0) {
                 $cuenta->update(['estado' => 'pagada']);
            }
        });

        $mensaje = $esPagoCompleto 
                      ? '✅ Cuota "' . $cuota->concepto . '" saldada por un total de $' . number_format($montoPagadoAhora, 2) . '.'
                      : '⚠️ Pago parcial de $' . number_format($montoPagadoAhora, 2) . ' registrado con éxito. Estado: PARCIAL.';
        
        // Asumo que esta línea también estaba funcionando con la ruta anidada en el redirect anterior.
        return redirect()->route('alumnos.show', $cuota->cuentaInscripcion->alumno_id)
                         ->with('success', $mensaje);
    }

    // =========================================================================
    // MÉTODOS DE RECIBO
    // =========================================================================

    public function verRecibo(CuotaPago $cuotaPago)
    {
        if ($cuotaPago->estado !== 'pagado') {
            return back()->with('error', '❌ Esta cuota aún no ha sido pagada o está incompleta.');
        }

        // CORRECCIÓN 2: Se carga la relación completa 'inscripcion.alumno.user'
        $cuotaPago->load('cuentaInscripcion.inscripcion.alumno.user', 'pagos.tipoPago'); // <<-- CORRECCIÓN APLICADA

        return view('cuotas.recibo', compact('cuotaPago'));
    }
    
    /**
     * Genera y descarga el PDF del recibo para una cuota específica.
     * * @param \App\Models\CuotaPago $cuota
     * @return \Illuminate\Http\Response
     */
    public function imprimirRecibo(CuotaPago $cuota)
    {
        // 1. Verificación de Estado
        if ($cuota->estado !== 'pagado') {
            return redirect()->back()->with('error', 'Solo se pueden imprimir recibos de cuotas que han sido pagadas completamente.');
        }

        // 2. Carga de Relaciones
        $cuota->load(['pagos']);
        
        // CORRECCIÓN 3: Se carga la relación completa 'inscripcion.alumno.user'
        $cuentaInscripcion = $cuota->cuentaInscripcion()->with('inscripcion.alumno.user')->first(); // <<-- CORRECCIÓN APLICADA
        
        if (!$cuentaInscripcion) {
             return redirect()->back()->with('error', 'No se encontró la cuenta de inscripción asociada a esta cuota.');
        }
        
        // 3. Obtención de Datos
        // Usamos la fecha del último pago para la fecha del recibo.
        $fechaRecibo = $cuota->pagos->max('fecha_pago') ?? now();

        // 4. Generación del PDF (usando la vista 'pdfs.recibo-pago')
        $pdf = Pdf::loadView('pdfs.recibo-pago', compact('cuota', 'fechaRecibo', 'cuentaInscripcion'));

        // 5. Descarga
        $nombreArchivo = "recibo-cuota-{$cuota->id}-{$fechaRecibo->format('Ym')}.pdf";
        
        return $pdf->download($nombreArchivo);
    }
}