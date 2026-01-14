<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Categoria;
use App\Models\Docente;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HorarioController extends Controller
{
    /**
     * Lista todos los horarios, agrupados por categoría, docente y hora.
     */
    public function index()
    {
        $horarios = Horario::with(['categoria', 'docente.user'])
                            ->get()
                            ->sortBy('categoria.nombre');

        $gruposHorarios = $horarios->groupBy(function ($item) {
            return "{$item->categoria_id}-{$item->docente_id}-{$item->hora_inicio}-{$item->hora_fin}";
        })->map(function ($grupo) {
            $dias = $grupo->pluck('dia_semana')->map(fn($d) => ucfirst($d))->unique()->implode(', '); 
            $primerHorario = $grupo->first();
            $grupoKey = "{$primerHorario->categoria_id}-{$primerHorario->docente_id}-{$primerHorario->hora_inicio}-{$primerHorario->hora_fin}";

            return (object) [
                'id' => $primerHorario->id, 
                'grupo_key' => $grupoKey, 
                'categoria_nombre' => optional($primerHorario->categoria)->nombre,
                'docente_nombre' => optional(optional($primerHorario->docente)->user)->name ?? 'Docente no asignado',
                'rango_hora' => Carbon::parse($primerHorario->hora_inicio)->format('H:i') . ' - ' . Carbon::parse($primerHorario->hora_fin)->format('H:i'),
                'dias_semana' => $dias, 
            ];
        });

        return view('horarios.index', [
            'horarios' => $gruposHorarios
        ]);
    }

    /**
     * Formulario para crear nuevo horario (múltiples días)
     */
    public function create()
    {
        $docentes = Docente::join('users', 'docentes.user_id', '=', 'users.id')
                            ->select('docentes.*', 'users.name as user_name')
                            ->orderBy('users.name')
                            ->get();

        return view('horarios.create_edit', [
            'categorias' => Categoria::orderBy('nombre')->get(),
            'docentes' => $docentes,
            'isEditing' => false,
        ]);
    }

    /**
     * Almacena uno o varios horarios (múltiples días)
     */
    public function store(Request $request)
    {
        $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'docente_id' => 'required|exists:docentes,id',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'dias_semana' => 'required|array|min:1',
            'dias_semana.*' => 'required|in:lunes,martes,miércoles,jueves,viernes,sábado',
        ]);

        $data = $request->only(['categoria_id', 'docente_id', 'hora_inicio', 'hora_fin']);
        $registros_creados = 0;

        foreach ($request->input('dias_semana') as $dia) {
            Horario::create(array_merge($data, ['dia_semana' => $dia]));
            $registros_creados++;
        }

        return redirect()->route('horarios.index')
                         ->with('success', "Clase creada correctamente para $registros_creados día(s) de la semana.");
    }

    /**
     * Formulario para editar un horario (solo un día)
     */
    public function edit(Horario $horario)
    {
        $docentes = Docente::join('users', 'docentes.user_id', '=', 'users.id')
                            ->select('docentes.*', 'users.name as user_name')
                            ->orderBy('users.name')
                            ->get();

        return view('horarios.create_edit', [
            'horario' => $horario,
            'categorias' => Categoria::orderBy('nombre')->get(),
            'docentes' => $docentes,
            'isEditing' => true,
        ]);
    }

    /**
     * Actualiza un horario existente
     */
    public function update(Request $request, Horario $horario)
    {
        $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'docente_id' => 'required|exists:docentes,id',
            'dia_semana' => 'required|string|in:lunes,martes,miércoles,jueves,viernes,sábado',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
        ]);

        $horario->update($request->only(['categoria_id','docente_id','dia_semana','hora_inicio','hora_fin']));

        return redirect()->route('horarios.index')
                         ->with('success', 'Horario actualizado');
    }

    /**
     * Elimina un solo horario
     */
    public function destroy(Horario $horario)
    {
        $horario->delete();

        return redirect()->route('horarios.index')
                         ->with('success', 'Horario de un día eliminado');
    }

    /**
     * Elimina todos los horarios de un mismo grupo
     */
    public function destroyGroup(string $grupo_key)
    {
        $parts = explode('-', $grupo_key);
        if (count($parts) !== 4) {
            return redirect()->route('horarios.index')
                             ->with('error', 'Clave de grupo de horario inválida.');
        }

        [$categoriaId, $docenteId, $horaInicio, $horaFin] = $parts;

        try {
            $conteo = Horario::where('categoria_id', $categoriaId)
                             ->where('docente_id', $docenteId)
                             ->where('hora_inicio', $horaInicio)
                             ->where('hora_fin', $horaFin)
                             ->delete();

            $msg = $conteo > 0
                   ? "Se eliminaron $conteo horarios (grupo completo)."
                   : 'No se encontraron horarios para eliminar con esa clave.';

            return redirect()->route('horarios.index')->with($conteo > 0 ? 'success' : 'error', $msg);

        } catch (\Exception $e) {
            return redirect()->route('horarios.index')
                             ->with('error', 'Error al eliminar el grupo: ' . $e->getMessage());
        }
    }
}
