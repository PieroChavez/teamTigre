<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    // 🔗 Relaciones

    public function horarios(): HasMany // 👈 Tipo de retorno explícito
{
    return $this->hasMany(Horario::class);
}

public function inscripciones(): HasMany // 👈 Tipo de retorno explícito
{
    return $this->hasMany(Inscripcion::class);
}
}
