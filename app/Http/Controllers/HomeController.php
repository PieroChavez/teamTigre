<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Models\Noticia;
use App\Models\Evento;
use Carbon\Carbon; 

class HomeController extends Controller
{
    /**
     * Crea una nueva instancia del controlador.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth'); 
    }

    /**
     * Muestra el dashboard del administrador con estadísticas.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // 1. Estadísticas de Alumnos
        $totalAlumnos = Alumno::count();
        $alumnosActivos = Alumno::where('status', 'activo')->count(); 

        // 🛑 LÍNEA AÑADIDA: Obtenemos los últimos 5 alumnos registrados
        $ultimosAlumnos = Alumno::orderBy('created_at', 'desc')->take(5)->get();
        
        // 2. Resumen de Noticias
        $ultimasNoticias = Noticia::orderBy('created_at', 'desc')->take(5)->get();
        
        // 3. Resumen de Eventos (próximos eventos)
        $proximosEventos = Evento::where('fecha', '>=', Carbon::today())
                                 ->orderBy('fecha', 'asc')
                                 ->take(3)
                                 ->get();

        // Enviamos todas las variables cargadas a la vista 'home'
        return view('home', compact(
            'totalAlumnos', 
            'alumnosActivos', 
            'ultimasNoticias', 
            'proximosEventos',
            'ultimosAlumnos' // 🛑 AÑADIDO: Para la nueva sección lateral del Dashboard
        ));
    }
}