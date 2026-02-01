<?php

namespace App\Http\Controllers;

use App\Models\PlantillaPeriodo;
use App\Http\Requests\StorePlantillaPeriodoRequest;
use Illuminate\Http\Request;

class PlantillaPeriodoController extends Controller
{
    /**
     * Listado de plantillas de periodo
     */
    public function index()
    {
        $periodos = PlantillaPeriodo::orderBy('nombre')->get();

        return view('plantilla_periodos.index', compact('periodos'));
    }

    /**
     * Formulario de creación
     */
    public function create()
    {
        return view('plantilla_periodos.create');
    }

    /**
     * Guardar nueva plantilla de periodo
     */
    public function store(StorePlantillaPeriodoRequest $request)
    {
        PlantillaPeriodo::create($request->validated());

        return redirect()
            ->route('plantilla-periodos.index')
            ->with('success', 'Plantilla de período creada correctamente');
    }

    /**
     * Formulario de edición
     */
    public function edit(PlantillaPeriodo $plantillaPeriodo)
    {
        return view('plantilla_periodos.edit', compact('plantillaPeriodo'));
    }

    /**
     * Actualizar plantilla de periodo
     */
    public function update(Request $request, PlantillaPeriodo $plantillaPeriodo)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'duracion_meses' => 'nullable|integer|min:1',
            'duracion_semanas' => 'nullable|integer|min:1',
            'precio_base' => 'required|numeric|min:0',
        ]);

        // Validación lógica: meses o semanas
        if (!$request->duracion_meses && !$request->duracion_semanas) {
            return back()
                ->withErrors(['duracion' => 'Debe indicar duración en meses o semanas'])
                ->withInput();
        }

        $plantillaPeriodo->update($request->only([
            'nombre',
            'duracion_meses',
            'duracion_semanas',
            'precio_base',
        ]));

        return redirect()
            ->route('plantilla-periodos.index')
            ->with('success', 'Plantilla de período actualizada correctamente');
    }

    /**
     * Eliminar plantilla de periodo
     */
    public function destroy(PlantillaPeriodo $plantillaPeriodo)
    {
        $plantillaPeriodo->delete();

        return redirect()
            ->route('plantilla-periodos.index')
            ->with('success', 'Plantilla de período eliminada correctamente');
    }
}
