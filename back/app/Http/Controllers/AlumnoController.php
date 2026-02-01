<?php

namespace App\Http\Controllers;

use App\Models\{
    Alumno,
    User,
    TipoPago,
    CuentaInscripcion,
    CuotaPago,
    Inscripcion,
    ConceptoPago,
    Pago
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Http\Requests\StorePagoRequest; // ⚠️ AÑADIDO: Importamos el Request de Pago

class AlumnoController extends Controller
{
    // ======================================================================
    // MÉTODOS CRUD BÁSICOS
    // ======================================================================
    
    public function index()
    {
        $alumnos = Alumno::with('user')->paginate(10);
        return view('alumnos.index', compact('alumnos'));
    }

    public function create()
    {
        return view('alumnos.create'); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'codigo_barra' => 'required|string|max:255|unique:alumnos,codigo_barra',
            'fecha_ingreso' => 'nullable|date',
            'estado' => 'required|string|in:activo,inactivo,suspendido',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            Alumno::create([
                'user_id' => $user->id,
                'codigo_barra' => $request->codigo_barra,
                'fecha_ingreso' => $request->fecha_ingreso,
                'estado' => $request->estado,
            ]);
        });

        return redirect()->route('alumnos.index')->with('status', 'Alumno y Usuario registrados correctamente.');
    }

    /**
     * Muestra el perfil del alumno, incluyendo su estado financiero.
     */
// app/Http/Controllers/AlumnoController.php

public function show(Alumno $alumno)
{
    // ⚠️ CARGAMOS TODAS LAS RELACIONES NECESARIAS
    $alumno->load([
        'user', 
        
        // Módulo de Inscripciones
        'inscripciones.categoria',
        'inscripciones.periodo',
        
        // Módulo Financiero con orden de pagos correcto
        'cuentasInscripcion.conceptoPago',
        'cuentasInscripcion.cuotas' => function ($query) {
            $query->with(['pagos' => function ($q) {
                $q->orderByDesc('created_at'); // 🔥 Pago más reciente primero
            }]);
        },
    ]); 

    // Catálogos para formulario de Registro de Pago
    $tiposPago = TipoPago::all();
    $conceptosPago = ConceptoPago::orderBy('nombre')->get();
    
    // Inscripciones vigentes para SELECT en el formulario de pago
    $inscripcionesActivas = $alumno->inscripciones()
        ->where('estado', 'vigente')
        ->get();

    // Retornamos la vista con todas las variables necesarias
    return view('alumnos.show', compact(
        'alumno', 
        'tiposPago', 
        'conceptosPago',
        'inscripcionesActivas'
    ));
}



    public function edit(Alumno $alumno)
    {
        return view('alumnos.edit', compact('alumno'));
    }

    public function update(Request $request, Alumno $alumno)
    {
        // ... (lógica de validación y actualización)
        $alumnoValidation = [
            'codigo_barra' => [
                'required', 'string', 'max:255',
                Rule::unique('alumnos', 'codigo_barra')->ignore($alumno->id),
            ],
            'fecha_ingreso' => 'nullable|date',
            'estado' => 'required|string|in:activo,inactivo,suspendido',
        ];

        $userValidation = [];
        if ($alumno->user) {
            $userValidation = [
                'name' => 'required|string|max:255',
                'email' => ['required','string','email','max:255', Rule::unique('users')->ignore($alumno->user_id)],
                'password' => 'nullable|string|min:8|confirmed',
            ];
        }

        $request->validate(array_merge($alumnoValidation, $userValidation));

        DB::transaction(function () use ($request, $alumno) {
            if ($alumno->user) {
                $userData = ['name' => $request->name, 'email' => $request->email];
                if ($request->filled('password')) {
                    $userData['password'] = Hash::make($request->password);
                }
                $alumno->user->update($userData);
            }

            $alumno->update($request->only(['codigo_barra', 'fecha_ingreso', 'estado']));
        });

        return redirect()->route('alumnos.index')->with('status', 'Alumno actualizado correctamente.');
    }

    public function destroy(Alumno $alumno)
    {
        // NOTA: Se recomienda usar 'soft deletes' para no perder historial de pagos/inscripciones
        $alumno->delete();
        return redirect()->route('alumnos.index')->with('status', 'Alumno eliminado correctamente.');
    }

    // ======================================================================
    // MÉTODOS DE PAGO Y DEUDA
    // ======================================================================
    
    /**
     * Registra un pago y lo aplica a las cuotas pendientes de una inscripción.
     */
public function registrarPago(StorePagoRequest $request, Alumno $alumno)
{
    $montoPendienteAplicar = $request->validated('monto');
    $montoTotalPagado = $montoPendienteAplicar;
    $inscripcionId = $request->validated('inscripcion_id');
    $referencia = $request->validated('referencia') ?? null;
    $tipoPagoId = $request->validated('tipo_pago_id');

    $cuenta = CuentaInscripcion::where('inscripcion_id', $inscripcionId)->firstOrFail();
    $tipoPago = TipoPago::findOrFail($tipoPagoId);

    $cuotasPendientes = $cuenta->cuotas()
        ->where('estado', '!=', 'pagado')
        ->orderBy('fecha_programada')
        ->get();

    $cuotasAfectadas = [];
    $ultimoPago = null;

    try {
        DB::beginTransaction();

        foreach ($cuotasPendientes as $cuota) {
            if ($montoPendienteAplicar <= 0.01) {
                break;
            }

            $montoYaPagado = $cuota->monto_pagado;
            $deudaRestante = $cuota->monto - $montoYaPagado;

            if ($deudaRestante <= 0.01) {
                continue;
            }

            $montoAplicado = min($montoPendienteAplicar, $deudaRestante);

            // 💰 Registrar pago
            $ultimoPago = Pago::create([
                'cuota_pago_id' => $cuota->id,
                'tipo_pago_id'  => $tipoPagoId,
                'monto'         => $montoAplicado,
                'fecha_pago'    => now(),
                'referencia'    => $referencia,
                'usuario_id'    => auth()->id(),
                'metodo'        => $tipoPago->nombre,
            ]);

            // 📌 Actualizar cuota
            $cuota->monto_pagado = $montoYaPagado + $montoAplicado;

            if ($cuota->monto_pagado >= $cuota->monto - 0.01) {
                $cuota->estado = 'pagado';
                $cuotasAfectadas[] = "Cuota {$cuota->id} ({$cuota->concepto}) PAGO TOTAL";
            } else {
                $cuota->estado = 'parcial';
                $cuotasAfectadas[] = "Cuota {$cuota->id} ({$cuota->concepto}) PAGO PARCIAL";
            }

            $cuota->save();
            $montoPendienteAplicar -= $montoAplicado;
        }

        // 🧾 Marcar cuenta como pagada si aplica
        if ($cuenta->cuotas()->where('estado', '!=', 'pagado')->count() === 0) {
            $cuenta->update(['estado' => 'pagada']);
        }

        DB::commit();

    } catch (\Throwable $e) {
        DB::rollBack();
        Log::error('Error en registrarPago: ' . $e->getMessage());

        return back()
            ->withInput()
            ->withErrors(['error' => 'Error al registrar el pago.']);
    }

    // ✅ MENSAJE FINAL
    $mensajeFinal = "Pago de S/ " . number_format($montoTotalPagado, 2) . " registrado correctamente.";

    // 🚀 VISTA INTERMEDIA (abre PDF en otra pestaña y vuelve)
    return view('pagos.redirect-recibo', [
        'pagoId'   => $ultimoPago->id,
        'alumnoId' => $alumno->id,
        'mensaje'  => $mensajeFinal,
    ]);
}


    /**
     * Asigna una Cuenta de Inscripción (Deuda) y genera las Cuotas de Pago.
     */
    public function asignarCuotaInscripcion(Request $request, Alumno $alumno)
    {
        $request->validate([
            'inscripcion_id' => ['required', Rule::exists('inscripciones', 'id')->where('alumno_id', $alumno->id)],
            'concepto_pago_id' => 'required|exists:conceptos_pago,id',
            'descuento' => 'nullable|numeric|min:0',
        ]);

        // 1️⃣ Obtener la Inscripción y el ConceptoPago (que define el plan)
        $inscripcion = Inscripcion::with(['categoria', 'periodo'])
            ->findOrFail($request->inscripcion_id);
        
        $conceptoPago = ConceptoPago::findOrFail($request->concepto_pago_id);

        DB::transaction(function () use ($request, $inscripcion, $conceptoPago, $alumno) {
            
            // 2️⃣ Calcular montos
            $precioCategoria = $inscripcion->categoria->precio_base;
            $meses = $inscripcion->periodo->duracion_meses; // Usamos la relación 'periodo'
            
            $montoTotal = $precioCategoria * max($meses, 1);
            $descuento = $request->descuento ?? 0;
            $montoFinal = max($montoTotal - $descuento, 0);

            // 3️⃣ Crear la CuentaInscripcion (Deuda)
            $cuenta = CuentaInscripcion::create([
                'inscripcion_id' => $inscripcion->id,
                'concepto_pago_id' => $conceptoPago->id,
                'monto_total' => $montoTotal,
                'descuento' => $descuento,
                'monto_final' => $montoFinal,
                'estado' => 'pendiente',
            ]);

            // 4️⃣ Generar las CuotasPago (PLAN DE PAGOS)
            $numCuotas = $conceptoPago->num_cuotas ?? 1;
            $frecuenciaDias = $conceptoPago->frecuencia_dias ?? 30;

            $montoCuotaBase = round($montoFinal / $numCuotas, 2);
            $residuo = $montoFinal - ($montoCuotaBase * $numCuotas);
            
            // La fecha de vencimiento inicia 30 días después de la fecha de inicio de la inscripción
            $fechaBaseVencimiento = Carbon::parse($inscripcion->fecha_inicio)->addDays($frecuenciaDias);

            for ($i = 0; $i < $numCuotas; $i++) {
                
                $montoActual = $montoCuotaBase;
                
                // Ajustar el residuo en la primera cuota
                if ($i === 0 && $residuo !== 0.00) {
                    $montoActual += $residuo;
                    $montoActual = round($montoActual, 2);
                }

                CuotaPago::create([
                    'cuenta_inscripcion_id' => $cuenta->id,
                    'concepto' => $conceptoPago->nombre . ' - Cuota ' . ($i + 1),
                    'monto' => $montoActual,
                    'monto_pagado' => 0.00,
                    'estado' => 'pendiente',
                    'fecha_vencimiento' => $fechaBaseVencimiento->copy(), // Usamos copy() para no modificar la referencia
                ]);
                
                // Avanzar a la siguiente fecha de vencimiento
                $fechaBaseVencimiento->addDays($frecuenciaDias);
            }
        });

        return redirect()->route('alumnos.show', $alumno->id)
                         ->with('status', '✅ Cuenta de Inscripción y Plan de Cuotas generado correctamente.');
    }

    /**
     * Marca una CuotaPago individual como pagada (pago completo de la cuota).
     * NOTA: Este método es más simple y no registra una transacción en la tabla 'pagos'.
     * El método 'registrarPago' es más robusto para pagos parciales.
     */
    public function pagarCuota(Request $request, CuotaPago $cuotaPago)
    {
        // ⚠️ RECOMENDACIÓN: Use 'registrarPago' para registrar transacciones y asegurar que la tabla 'pagos' tenga registros.
        // Este método actual es útil solo para marcar rápidamente una cuota como pagada sin registrar el detalle del pago.

        if ($cuotaPago->estado !== 'pendiente') {
            return back()->with('error', 'La cuota ya fue pagada o tiene un estado diferente.');
        }

        DB::beginTransaction();

        try {
            // Se marca la cuota como pagada, asumiendo que el monto_pagado es igual al monto total.
            $cuotaPago->update([
                'estado' => 'pagado',
                'fecha_pago' => $request->fecha_pago ?? now(),
                'monto_pagado' => $cuotaPago->monto,
            ]);

            $cuenta = $cuotaPago->cuentaInscripcion;
            $cuotasPendientes = $cuenta->cuotas()->where('estado', 'pendiente')->count();

            if ($cuotasPendientes === 0) {
                $cuenta->update(['estado' => 'pagada']);
            }

            // Opcional: Crear un registro de Pago para mantener el historial completo.
            // Pago::create([
            //     'cuota_pago_id' => $cuotaPago->id,
            //     'tipo_pago_id' => $request->tipo_pago_id ?? 1, // Usar un valor por defecto o requerir uno
            //     'monto' => $cuotaPago->monto,
            //     'fecha_pago' => $cuotaPago->fecha_pago,
            //     'referencia' => 'Pago Rápido',
            // ]);

            DB::commit();

            $alumnoId = $cuenta->inscripcion->alumno_id ?? $cuenta->alumno_id;
            return redirect()->route('alumnos.show', $alumnoId)
                             ->with('status', 'Cuota marcada como PAGADA. Cuenta actualizada.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al procesar el pago de la cuota: ' . $e->getMessage());
        }
    }
}