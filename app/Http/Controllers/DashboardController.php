<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Docente;
use App\Models\PlantillaPeriodo;
use App\Models\Alumno;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsuarios = User::count();
        $totalDocentes = Docente::count();
        $totalPeriodos = PlantillaPeriodo::count();

        // Últimos alumnos
        $ultimosAlumnos = Alumno::latest()->take(5)->get();

        // Últimos docentes
        $ultimosDocentes = Docente::latest()->take(5)->get();

        // Datos para gráficos (ejemplo: usuarios por mes)
        $usuariosPorMes = User::selectRaw("MONTH(created_at) as mes, COUNT(*) as total")
                                ->groupBy('mes')
                                ->orderBy('mes')
                                ->pluck('total', 'mes');

        return view('dashboard', compact(
            'totalUsuarios',
            'totalDocentes',
            'totalPeriodos',
            'ultimosAlumnos',
            'ultimosDocentes',
            'usuariosPorMes'
        ));
    }
}
