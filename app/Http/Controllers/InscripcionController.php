<?php

namespace App\Http\Controllers;

use App\Models\Inscripcion;
use App\Models\Alumno;
use App\Models\Categoria;
use App\Models\Horario;
use App\Models\PlantillaPeriodo;
use App\Models\ConceptoPago;
use App\Models\CuentaInscripcion; 
use App\Models\CuotaPago;
use App\Models\TipoPago;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;
use App\Http\Requests\StoreInscripcionRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller; 
use Illuminate\Support\Str;

class InscripcionController extends Controller
{
    /**
     * Muestra una lista de inscripciones
     */
    public function index()
    {
        $inscripciones = Inscripcion::with(['alumno.user', 'categoria', 'periodo'])
                                    ->latest()
                                    ->simplePaginate(15);

        return view('inscripciones.index', compact('inscripciones'));
    }

    /**
     * Formulario para crear nueva inscripción
     */
    public function create(Request $request)
    {
        $alumnos = Alumno::with('user')->get(); 
        $categorias = Categoria::all(); 
        $horarios = Horario::all(); 
        $periodos = PlantillaPeriodo::all();
        $conceptosPago = ConceptoPago::all(); 

        $alumnoId = $request->query('alumno_id'); 

        return view('inscripciones.create', compact(
            'alumnos', 
            'categorias', 
            'horarios', 
            'periodos', 
            'conceptosPago',
            'alumnoId'
        ));
    }

    /**
     * Guardar nueva inscripción y generar Cuenta de Deuda y Cuotas.
     */
    public function store(StoreInscripcionRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                
                // 1. Crear la Inscripción 
                $validated = $request->validated();
                $inscripcion = Inscripcion::create($validated); 

                // 2. Crear la Cuenta de Deuda y las Cuotas asociadas
                $this->crearCuentaYCuotas(
                    $inscripcion, 
                    (int)$request->concepto_pago_id, 
                    (float)$request->monto_total_inscripcion
                );
            });

            return redirect()
                ->route('alumnos.show', $request->alumno_id)
                ->with('success', '✅ Inscripción y plan de pagos creados correctamente.');

        } catch (\Exception $e) {
            \Log::error("Error en InscripcionController@store: " . $e->getMessage(), ['exception' => $e]);
            
            return back()
                ->withInput()
                ->with('error', '❌ Error al crear la inscripción y las cuotas: ' . $e->getMessage()); 
        }
    }

    /**
     * Ver detalle de inscripción
     */
    public function show(Inscripcion $inscripcion)
    {
        $inscripcion->load([
            'alumno.user', 
            'categoria',
            'horario',
            'periodo', 
            'cuentasInscripcion.conceptoPago',
            'cuentasInscripcion.cuotas.pagos', 
            'asistencias'
        ]);

        return view('inscripciones.show', compact('inscripcion'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Inscripcion $inscripcion)
    {
        $alumnos = Alumno::with('user')->get(); 
        $categorias = Categoria::all(); 
        $horarios = Horario::all(); 
        $periodos = PlantillaPeriodo::all();
        $conceptosPago = ConceptoPago::all(); 

        return view('inscripciones.edit', compact(
            'inscripcion',
            'alumnos',
            'categorias',
            'horarios',
            'periodos',
            'conceptosPago'
        ));
    }

    /**
     * Actualizar inscripción
     */
    public function update(Request $request, Inscripcion $inscripcion)
    {
        $validated = $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'periodo_id' => 'required|exists:plantilla_periodos,id',
            'horario_id' => 'nullable|exists:horarios,id',
            'modalidad_pago' => 'nullable|string',
            'costo_total' => 'required|numeric',
            'estado' => 'required|string',
        ]);

        $inscripcion->update($validated);

        return redirect()->route('alumnos.show', $inscripcion->alumno_id)
                         ->with('success', '✅ Inscripción actualizada correctamente.');
    }

    /**
     * Genera y descarga la ficha de inscripción en PDF
     */
    /**
     * Genera y descarga la ficha de inscripción en PDF
     */
    public function imprimirFicha(Alumno $alumno)
    {
        // Cargamos todas las relaciones necesarias para la vista PDF
        $alumno->load([
            'user', 
            'inscripciones.categoria', 
            'inscripciones.periodo',
            'inscripciones.horario',
            'inscripciones.cuentasInscripcion.cuotas' // Añadido para mostrar deudas en el PDF
        ]);
        
        // Generación del PDF usando la vista que definimos anteriormente
        $pdf = PDF::loadView('pdfs.ficha-inscripcion', compact('alumno'));
        
        // Configuramos el nombre del archivo: ficha_nombre_apellido_fecha.pdf
        $filename = 'ficha_inscripcion_' . Str::slug($alumno->user->name, '_') . '_' . now()->format('Ymd') . '.pdf';
        
        // Opcional: Si quieres ver el PDF en el navegador antes de descargar, cambia download por stream
        return $pdf->download($filename); 
    }

    /**
     * Crear Cuenta de Deuda y Cuotas
     */
    private function crearCuentaYCuotas(Inscripcion $inscripcion, int $conceptoPagoId, float $montoTotal): void
    {
        $conceptoPago = ConceptoPago::findOrFail($conceptoPagoId);
        $numCuotas = $conceptoPago->num_cuotas ?? 1;

        $frecuenciaMeses = match ((int)($conceptoPago->frecuencia_dias ?? 30)) {
            30, 31 => 1,
            60, 61 => 2,
            90, 91, 92 => 3,
            120, 121, 122 => 4,
            default => 1,
        };

        $montoCuotaBase = round($montoTotal / $numCuotas, 2);
        $residuo = $montoTotal - ($montoCuotaBase * $numCuotas);

        $cuenta = CuentaInscripcion::create([
            'inscripcion_id' => $inscripcion->id,
            'concepto_pago_id' => $conceptoPagoId,
            'monto_total' => $montoTotal,
            'descuento' => 0.00, 
            'monto_final' => $montoTotal,
            'estado' => 'pendiente',
        ]);

        $tipoPagoPorDefecto = TipoPago::where('nombre', 'like', '%Cuota%')->first() ?? TipoPago::first();
        $tipoPagoPorDefectoId = $tipoPagoPorDefecto->id ?? 1;

        $fechaVencimiento = Carbon::parse($inscripcion->fecha_inicio);
        $fechaVencimiento->addMonths($frecuenciaMeses);

        $cuotasData = [];
        for ($i = 0; $i < $numCuotas; $i++) {
            $montoActual = $montoCuotaBase;
            if ($i === 0) {
                $montoActual = round($montoActual + $residuo, 2);
            }

            $cuotasData[] = [
                'cuenta_inscripcion_id' => $cuenta->id,
                'tipo_pago_id' => $tipoPagoPorDefectoId,
                'concepto' => $conceptoPago->nombre . ' - Cuota ' . ($i + 1),
                'monto' => $montoActual,
                'monto_pagado' => 0.00, 
                'fecha_programada' => $fechaVencimiento->toDateString(),
                'estado' => 'pendiente',
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $fechaVencimiento->addMonths($frecuenciaMeses);
        }

        if (!empty($cuotasData)) {
            CuotaPago::insert($cuotasData);
        }
    }
}
