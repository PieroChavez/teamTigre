<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use Illuminate\Http\Request;

class NoticiaController extends Controller
{
    // ADMIN
    public function index()
    {
        $noticias = Noticia::latest()->get();
        return view('noticias.index', compact('noticias'));
    }

    public function create()
    {
        return view('noticias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:200',
            'contenido' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $rutaImagen = null;

        if ($request->hasFile('imagen')) {
            $rutaImagen = $request->file('imagen')->store('noticias', 'public');
        }

        Noticia::create([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'imagen' => $rutaImagen,
        ]);

        return redirect()->route('noticias.index')
            ->with('success', 'Noticia publicada correctamente');
    }

    // WEB PÚBLICA
    public function web()
    {
        $noticias = Noticia::latest()->paginate(6);
        return view('web.noticias', compact('noticias'));
    }

    public function show(Noticia $noticia)
    {
        return view('web.noticia', compact('noticia'));
    }
}
