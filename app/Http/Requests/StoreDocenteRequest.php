<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class StoreDocenteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            // Reglas para la tabla 'users'
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', 'min:8'],
            
            // Reglas para la tabla 'docentes'
            'dni' => ['required', 'string', 'max:20', 'unique:docentes,dni'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'especialidad' => ['required', 'string', 'max:50'],
            'experiencia' => ['nullable', 'string'],
        ];
    }
}