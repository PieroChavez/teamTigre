<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

use App\Models\Role;
use App\Models\Alumno;
use App\Models\Docente;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ====================================================
    // RELACIÓN USUARIO ↔ ROLES (Muchos a Muchos)
    // ====================================================

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    // ====================================================
    // LÓGICA DE ROLES
    // ====================================================

    /**
     * Verifica si el usuario tiene un rol específico.
     * Ej: Admin, Ventas, Alumno, cliente
     */
    public function hasRole(string $roleName): bool
    {
        return $this->roles()
            ->where('nombre', $roleName)
            ->exists();
    }

    /**
     * Devuelve el nombre del primer rol del usuario
     */
    public function getPrimaryRole(): ?string
    {
        return $this->roles()
            ->pluck('nombre')
            ->first();
    }

    // ====================================================
    // RELACIONES DE PERFIL (Uno a Uno)
    // ====================================================

    public function alumno(): HasOne
    {
        return $this->hasOne(Alumno::class);
    }

    public function docente(): HasOne
    {
        return $this->hasOne(Docente::class);
    }
}
