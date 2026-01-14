<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDocenteRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Define la lógica de autorización. Por ahora, déjalo en true.
        return true;
    }

    public function rules(): array
    {
        // Accedemos al modelo Docente de la ruta para ignorar su ID
        $docente = $this->route('docente');

        return [
            // Reglas para la tabla 'users'
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 
                'string', 
                'lowercase', 
                'email', 
                'max:255', 
                Rule::unique('users')->ignore($docente->user->id) // Ignorar email actual
            ],
            'password' => ['nullable', 'confirmed', 'min:8'],
            
            // Reglas para la tabla 'docentes'
            'dni' => [
                'required', 
                'string', 
                'max:20', 
                Rule::unique('docentes')->ignore($docente->id) // Ignorar DNI actual
            ],
            'telefono' => ['nullable', 'string', 'max:20'],
            'especialidad' => ['required', 'string', 'max:50'],
            'estado' => ['required', 'in:activo,inactivo'],
            'experiencia' => ['nullable', 'string'],
        ];
    }
}