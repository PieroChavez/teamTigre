<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Models\Categoria;



class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alumnos = Alumno::with('categoria')->get();
        return view('alumnos.index', compact('alumnos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::all();
        return view('alumnos.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'fecha_nacimiento' => 'required|date',
            'categoria_id' => 'required|exists:categorias,id',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $rutaFoto = null;

        if ($request->hasFile('foto')) {
            $rutaFoto = $request->file('foto')->store('alumnos', 'public');
        }

        Alumno::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'categoria_id' => $request->categoria_id,
            'foto' => $rutaFoto,
        ]);

        return redirect()->route('alumnos.index')
            ->with('success', 'Alumno registrado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
