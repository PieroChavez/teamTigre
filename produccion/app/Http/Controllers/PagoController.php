<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Pago;
use App\Models\HistorialPago;
use App\Models\Evento; // <<<<<<<<<<<< ¡NECESARIO!
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagoController extends Controller
{
    // Mostrar todos los pagos de un alumno
    public function index(Alumno $alumno)
    {
        // Incluye pagos activos y anulados
        $pagos = $alumno->pagos()->withTrashed()->orderBy('fecha_pago', 'desc')->get();

        return view('pagos.index', compact('alumno', 'pagos'));
    }

    // Guardar un nuevo pago
    public function store(Request $request, Alumno $alumno)
    {
        $request->validate([
            'monto' => 'required|numeric|min:0',
            'fecha_pago' => 'required|date',
            'concepto' => 'nullable|string|max:255',
        ]);

        $pago = Pago::create([
            'alumno_id' => $alumno->id,
            'monto' => $request->monto,
            'fecha_pago' => $request->fecha_pago,
            'concepto' => $request->concepto,
            'estado' => 'activo',
        ]);

        // Registrar historial
        HistorialPago::create([
            'pago_id' => $pago->id,
            'user_id' => Auth::id() ?? 1, // temporal para pruebas sin login
            'accion' => 'creado',
            'detalle' => "Pago de S/ {$pago->monto} registrado.",
        ]);

        return redirect()->route('alumnos.pagos', $alumno->id)
            ->with('success', 'Pago registrado correctamente');
    }

    // Mostrar formulario de edición
    public function edit(Pago $pago)
    {
        if ($pago->estado === 'anulado') {
            return redirect()->route('alumnos.pagos', $pago->alumno_id)
                ->with('error', 'No se puede editar un pago anulado.');
        }

        return view('pagos.edit', compact('pago'));
    }

    // Actualizar pago
    public function update(Request $request, Pago $pago)
    {
        if ($pago->estado === 'anulado') {
            return redirect()->route('alumnos.pagos', $pago->alumno_id)
                ->with('error', 'No se puede editar un pago anulado.');
        }

        $request->validate([
            'monto' => 'required|numeric|min:0',
            'fecha_pago' => 'required|date',
            'concepto' => 'nullable|string|max:255',
        ]);

        $pago->update([
            'monto' => $request->monto,
            'fecha_pago' => $request->fecha_pago,
            'concepto' => $request->concepto,
        ]);

        // Registrar historial
        HistorialPago::create([
            'pago_id' => $pago->id,
            'user_id' => Auth::id() ?? 1,
            'accion' => 'editado',
            'detalle' => "Pago modificado a S/ {$pago->monto}.",
        ]);

        return redirect()->route('alumnos.pagos', $pago->alumno_id)
            ->with('success', 'Pago actualizado correctamente');
    }

    // Anular un pago
    public function destroy(Pago $pago)
    {
        // Registrar historial antes de anular
        HistorialPago::create([
            'pago_id' => $pago->id,
            'user_id' => Auth::id() ?? 1,
            'accion' => 'anulado',
            'detalle' => "Pago de S/ {$pago->monto} anulado.",
        ]);

        // Anular y SoftDelete
        $pago->update(['estado' => 'anulado']);
        $pago->delete();

        return redirect()->route('alumnos.pagos', $pago->alumno_id)
            ->with('success', 'Pago anulado correctamente');
    }
    

    public function showEventPayments(Evento $evento)
    {

        $alumnoIds = $evento->alumnos->pluck('id');

        $pagos = Pago::whereIn('alumno_id', $alumnoIds)
                     ->with('alumno') 
                     ->withTrashed() 
                     ->orderBy('fecha_pago', 'desc')
                     ->get();

        return view('eventos.pagos', compact('evento', 'pagos'));

    }
}