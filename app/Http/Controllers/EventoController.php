<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\Alumno;


class EventoController extends Controller
{
    public function index()
    {
        $eventos = Evento::orderBy('fecha', 'desc')->get();
        return view('eventos.index', compact('eventos'));
    }



    public function create()
    {
        return view('eventos.create');
    }



    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:150',
            'fecha' => 'required|date',
            'descripcion' => 'nullable|string',
        ]);

        Evento::create($request->all());

        return redirect()->route('eventos.index')
            ->with('success', 'Evento creado correctamente');
    }



    public function web()
    {
        $eventos = Evento::latest()->get();
        return view('web.eventos', compact('eventos'));
    }

    public function showWeb(Evento $evento)
    {
        $evento->load('alumnos.categoria');
        return view('web.evento', compact('evento'));
    }



    public function inscribir(Evento $evento)
    {
        $alumnos = Alumno::all();
        return view('eventos.inscribir', compact('evento', 'alumnos'));
    }

    public function guardarInscripcion(Request $request, Evento $evento)
    {
        $evento->alumnos()->sync($request->alumnos);
        return redirect()->route('eventos.index')
            ->with('success', 'Alumnos inscritos correctamente');
    }


}
