<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlantillaPeriodoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255',
            'duracion_meses' => 'nullable|integer|min:1',
            'duracion_semanas' => 'nullable|integer|min:1',
            'precio_base' => 'required|numeric|min:0',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->duracion_meses && !$this->duracion_semanas) {
                $validator->errors()->add(
                    'duracion',
                    'Debe indicar duración en meses o semanas.'
                );
            }
        });
    }
}
