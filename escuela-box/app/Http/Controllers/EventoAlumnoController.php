<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Alumno;
use Illuminate\Http\Request;

class EventoAlumnoController extends Controller
{
    public function create(Evento $evento)
    {
        $alumnos = Alumno::with('categoria')->get();

        return view('eventos.alumnos', compact('evento', 'alumnos'));
    }

    public function store(Request $request, Evento $evento)
    {
        $request->validate([
            'alumnos' => 'required|array',
        ]);

        $evento->alumnos()->syncWithoutDetaching($request->alumnos);

        return redirect()->route('eventos.index')
            ->with('success', 'Alumnos inscritos al evento');
    }
}
