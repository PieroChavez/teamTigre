<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Inscripcion;
use App\Http\Requests\StoreAsistenciaRequest;
use Illuminate\Http\Request;

class AsistenciaController extends Controller
{
    /**
     * Listado de asistencias
     */
    public function index()
    {
        $asistencias = Asistencia::with([
                'inscripcion.alumno',
                'inscripcion.categoria',
                'inscripcion.horario'
            ])
            ->orderByDesc('fecha')
            ->get();

        return view('asistencias.index', compact('asistencias'));
    }

    /**
     * Formulario de registro de asistencia
     */
    public function create()
    {
        $inscripciones = Inscripcion::with([
                'alumno',
                'categoria',
                'horario'
            ])
            ->where('estado', 'vigente')
            ->get();

        return view('asistencias.create', compact('inscripciones'));
    }

    /**
     * Guardar asistencia
     */
    public function store(StoreAsistenciaRequest $request)
    {
        Asistencia::create($request->validated());

        return redirect()
            ->route('asistencias.index')
            ->with('success', 'Asistencia registrada correctamente');
    }

    /**
     * Formulario de edición
     */
    public function edit(Asistencia $asistencia)
    {
        return view('asistencias.edit', compact('asistencia'));
    }

    /**
     * Actualizar asistencia
     */
    public function update(Request $request, Asistencia $asistencia)
    {
        $request->validate([
            'fecha' => 'required|date',
            'hora_ingreso' => 'required|date_format:H:i',
            'metodo' => 'required|in:dni,lector,manual',
        ]);

        $asistencia->update($request->only([
            'fecha',
            'hora_ingreso',
            'metodo',
        ]));

        return redirect()
            ->route('asistencias.index')
            ->with('success', 'Asistencia actualizada correctamente');
    }

    /**
     * Eliminar asistencia
     */
    public function destroy(Asistencia $asistencia)
    {
        $asistencia->delete();

        return redirect()
            ->route('asistencias.index')
            ->with('success', 'Asistencia eliminada correctamente');
    }
}
