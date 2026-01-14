<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use Barryvdh\DomPDF\Facade\Pdf;

class TuControladorDePagos extends Controller
{
    /**
     * Lista de pagos (opcional)
     */
    public function index()
    {
        $pagos = Pago::with([
            'cuotaPago.cuentaInscripcion.alumno',
            'tipoPago',
            'usuario'
        ])->orderByDesc('fecha_pago')->paginate(15);

        return view('pagos.index', compact('pagos'));
    }

    /**
     * Genera y descarga el PDF del recibo/nota de venta.
     */
    public function imprimirRecibo($id)
    {
        // Carga el pago con todas las relaciones necesarias
        $pago = Pago::with([
            'cuotaPago.cuentaInscripcion.alumno',
            'tipoPago',
            'usuario'
        ])->find($id);

        if (!$pago) {
            return redirect()->back()->with('error', 'Pago no encontrado.');
        }

        $pdf = Pdf::loadView('pdfs.recibo-pago', compact('pago'));

        return $pdf->stream("nota-venta-{$pago->id}.pdf");
    }
}
