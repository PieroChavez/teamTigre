<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\StudentProfile;
use App\Models\Category;
use App\Models\Plan;
use App\Models\User;

class Enrollment extends Model
{
    protected $fillable = [
        'student_profile_id',
        'category_id',
        'plan_id',
        'start_date',
        'end_date',
        'status',
    ];

    // 🧑 PERFIL DEL ALUMNO
    public function studentProfile()
    {
        return $this->belongsTo(StudentProfile::class);
    }

    // 👤 USUARIO DEL ALUMNO (ACCESO DIRECTO)
    public function student()
    {
        return $this->hasOneThrough(
            User::class,
            StudentProfile::class,
            'id',               // StudentProfile.id
            'id',               // User.id
            'student_profile_id',
            'user_id'
        );
    }

    // 📚 CATEGORÍA
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // 📦 PLAN
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    // Asistencias del alumno en esta categoría
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
