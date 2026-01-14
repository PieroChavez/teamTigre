<?php

namespace App\Http\Controllers;

use App\Models\TipoPago;
use Illuminate\Http\Request;

class TipoPagoController extends Controller
{
    /**
     * Muestra una lista de todos los Tipos de Pago.
     */
    public function index()
    {
        // Obtiene todos los tipos de pago, ordenados por ID
        $tiposPago = TipoPago::orderBy('id', 'asc')->get();
        return view('tipos_pago.index', compact('tiposPago'));
    }

    /**
     * Muestra el formulario para crear un nuevo Tipo de Pago.
     */
    public function create()
    {
        return view('tipos_pago.create');
    }

    /**
     * Almacena un Tipo de Pago recién creado en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            // Aseguramos que el nombre sea obligatorio, string y único en la tabla
            'nombre' => 'required|string|max:255|unique:tipos_pago,nombre',
        ]);

        TipoPago::create($request->all());

        return redirect()->route('tipos_pago.index')->with('success', 'El Tipo de Pago fue creado exitosamente.');
    }

    /**
     * Muestra el formulario para editar el Tipo de Pago especificado.
     */
    public function edit(TipoPago $tipoPago)
    {
        return view('tipos_pago.edit', compact('tipoPago'));
    }

    /**
     * Actualiza el Tipo de Pago especificado en la base de datos.
     */
    public function update(Request $request, TipoPago $tipoPago)
    {
        $request->validate([
            // Aseguramos que el nombre sea único, excepto para el ID actual
            'nombre' => 'required|string|max:255|unique:tipos_pago,nombre,' . $tipoPago->id,
        ]);

        $tipoPago->update($request->all());

        return redirect()->route('tipos_pago.index')->with('success', 'El Tipo de Pago fue actualizado exitosamente.');
    }

    /**
     * Elimina el Tipo de Pago especificado de la base de datos.
     */
    public function destroy(TipoPago $tipoPago)
    {
        try {
            $tipoPago->delete();
            return redirect()->route('tipos_pago.index')->with('success', 'El Tipo de Pago fue eliminado exitosamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            // Código 23000 es la violación de integridad (Foreign Key Constraint)
            if ($e->getCode() == 23000) {
                 return redirect()->route('tipos_pago.index')->with('error', 'No se puede eliminar este Tipo de Pago porque está asociado a pagos existentes. Primero debe actualizar o eliminar los pagos vinculados.');
            }
            return redirect()->route('tipos_pago.index')->with('error', 'Ocurrió un error inesperado al intentar eliminar el Tipo de Pago.');
        }
    }
}