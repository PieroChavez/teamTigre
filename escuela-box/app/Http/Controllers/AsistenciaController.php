<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Models\Asistencia;
use Carbon\Carbon;

class AsistenciaController extends Controller
{
    public function index()
    {
        $fechaHoy = Carbon::today()->toDateString();

        $alumnos = Alumno::with(['asistencias' => function ($q) use ($fechaHoy) {
            $q->where('fecha', $fechaHoy);
        }])->get();

        return view('asistencias.index', compact('alumnos', 'fechaHoy'));
    }

    public function store(Request $request)
    {
        $fecha = $request->fecha;

        foreach ($request->alumnos ?? [] as $alumnoId => $presente) {

            // Evitar duplicados manualmente
            $existe = Asistencia::where('alumno_id', $alumnoId)
                ->where('fecha', $fecha)
                ->exists();

            if (!$existe) {
                Asistencia::create([
                    'alumno_id' => $alumnoId,
                    'fecha' => $fecha,
                    'presente' => true,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Asistencia registrada correctamente');
    }

    public function historial(Alumno $alumno)
    {
        $asistencias = $alumno->asistencias()
            ->orderBy('fecha', 'desc')
            ->get();

        return view('asistencias.historial', compact('alumno', 'asistencias'));
    }
}
