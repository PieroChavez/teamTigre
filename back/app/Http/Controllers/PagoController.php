<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\CuotaPago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PagoController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'alumno_id'      => 'required|exists:alumnos,id',
            'monto'          => 'required|numeric|min:0.01',
            'tipo_pago_id'   => 'required|exists:tipos_pago,id',
            'inscripcion_id' => 'required', 
            'referencia'     => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            /**
             * 2. BUSCAR LA CUOTA DE FORMA SEGURA
             * Ajustamos la relación: Cuota -> CuentaInscripcion -> Inscripcion (donde vive alumno_id)
             */
            $cuota = CuotaPago::whereHas('cuentaInscripcion.inscripcion', function($q) use ($validated) {
                    $q->where('alumno_id', $validated['alumno_id']);
                })
                ->orderBy('fecha_programada', 'asc')
                ->get()
                ->filter(fn($c) => ($c->monto_pendiente ?? 0) > 0.01)
                ->first();

            if (!$cuota) {
                return back()->with('error', 'No se encontró una cuota pendiente para este alumno en este programa.');
            }

            // 3. CREAR EL PAGO
            $pago = Pago::create([
                'alumno_id'     => $validated['alumno_id'],
                'tipo_pago_id'  => $validated['tipo_pago_id'],
                'cuota_pago_id' => $cuota->id,
                'monto'         => $validated['monto'],
                'comentario'    => $validated['referencia'], 
                'fecha_pago'    => now(),
                'user_id'       => auth()->id(),
            ]);

            // 4. ACTUALIZAR EL SALDO
            // Intentamos detectar el nombre de la columna de acumulado (monto_pagado o monto_pagado_total)
            $columnaPagado = DB::getSchemaBuilder()->hasColumn('cuota_pagos', 'monto_pagado_total') 
                             ? 'monto_pagado_total' 
                             : 'monto_pagado';

            $cuota->increment($columnaPagado, $validated['monto']);

            DB::commit();
            return back()->with('success', '¡Pago de S/' . number_format($validated['monto'], 2) . ' registrado!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al procesar el pago: ' . $e->getMessage());
        }
    }

    public function imprimirRecibo(Pago $pago)
    {
        $pago->load(['cuotaPago', 'cuotaPago.cuentaInscripcion.inscripcion.alumno', 'tipoPago', 'usuario']);
        return Pdf::loadView('pdfs.recibo-pago', compact('pago'))
                  ->setPaper('A4', 'portrait')
                  ->stream('recibo-' . $pago->id . '.pdf');
    }
}