<?php

namespace App\Http\Livewire\Pagos;

use Livewire\Component;
use App\Models\Alumno;
use App\Models\Inscripcion;

class CuotasAlumno extends Component
{
    public $alumnos;
    public $selectedAlumno = null;
    public $cuotas = [];

    public function mount()
    {
        $this->alumnos = Alumno::all();
    }

    public function updatedSelectedAlumno($alumnoId)
    {
        $inscripcion = Inscripcion::where('alumno_id', $alumnoId)->where('estado', 'activo')->first();
        $this->cuotas = $inscripcion ? $inscripcion->cuentasInscripcion()->with('cuotasPago')->get() : [];
    }

    public function render()
    {
        return view('livewire.pagos.cuotas-alumno');
    }
}
