<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Enrollment;

class Attendance extends Model
{
    protected $fillable = [
        'enrollment_id',
        'date',
        'status',
        'notes',
    ];

    // Relación: una asistencia pertenece a una inscripción
    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }
}
