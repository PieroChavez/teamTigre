<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Horario extends Model
{
    use HasFactory;

    protected $table = 'horarios';

    protected $fillable = [
        'docente_id',
        'categoria_id',
        'dia_semana',
        'hora_inicio',
        'hora_fin',
    ];

    protected $casts = [
        'hora_inicio' => 'datetime',
        'hora_fin' => 'datetime',
    ];

    /**
     * Relación: Un horario pertenece a un Docente.
     */
    public function docente(): BelongsTo
    {
        return $this->belongsTo(Docente::class);
    }

    /**
     * Relación: Un horario pertenece a una Categoria (Clase/Materia).
     */
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    /**
     * Devuelve todos los días de la semana para este grupo de horario
     * (mismo docente, categoría y rango de hora).
     * Esto es útil para marcar los checkboxes en edición múltiple.
     */
    public function groupedDias(): array
    {
        return self::where('categoria_id', $this->categoria_id)
                   ->where('docente_id', $this->docente_id)
                   ->where('hora_inicio', $this->hora_inicio)
                   ->where('hora_fin', $this->hora_fin)
                   ->pluck('dia_semana')
                   ->toArray();
    }
}
