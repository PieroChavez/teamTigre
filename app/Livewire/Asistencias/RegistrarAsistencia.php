<?php

namespace App\Http\Livewire\Asistencias;

use Livewire\Component;
use App\Models\Alumno;
use App\Models\Inscripcion;
use App\Models\Asistencia;
use Carbon\Carbon;

class RegistrarAsistencia extends Component
{
    public $dni;
    public $mensaje;

    protected $rules = [
        'dni' => 'required|digits:8', // Ajusta según el formato de DNI
    ];

    public function registrar()
    {
        $this->validate();

        $alumno = Alumno::where('dni', $this->dni)->first();

        if (!$alumno) {
            $this->mensaje = "Alumno no encontrado con DNI: {$this->dni}";
            return;
        }

        $inscripcion = Inscripcion::where('alumno_id', $alumno->id)
            ->where('estado', 'activo')
            ->first();

        if (!$inscripcion) {
            $this->mensaje = "El alumno no tiene inscripción activa.";
            return;
        }

        // Verificar que no haya registrado asistencia hoy
        $hoy = Carbon::today();
        if (Asistencia::where('inscripcion_id', $inscripcion->id)->where('fecha', $hoy)->exists()) {
            $this->mensaje = "Asistencia ya registrada para hoy.";
            return;
        }

        Asistencia::create([
            'inscripcion_id' => $inscripcion->id,
            'fecha' => $hoy,
            'hora_ingreso' => Carbon::now()->format('H:i:s'),
            'metodo' => 'dni',
        ]);

        $this->mensaje = "Asistencia registrada para {$alumno->nombre} {$alumno->apellido}";
        $this->dni = '';
    }

    public function render()
    {
        return view('livewire.asistencias.registrar-asistencia');
    }
}
