<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAsistenciaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'inscripcion_id' => 'required|exists:inscripciones,id',
            'fecha' => 'required|date',
            'hora_ingreso' => 'required|date_format:H:i',
            'metodo' => 'nullable|in:dni,lector,manual',
        ];
    }
}
