<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        // El parámetro de ruta que viene es el modelo User ($student).
        $studentUser = $this->route('student');

        // ID del usuario (modelo User)
        $userId = $studentUser->id;

        // ID del perfil de alumno (modelo StudentProfile)
        // Usamos null coalescing para evitar errores si el perfil no existe
        $studentProfileId = $studentUser->studentProfile->id ?? null;
        
        return [
            // Reglas para User
            'name' => ['required', 'string', 'max:255'],
            // ✅ CORREGIDO: Ignoramos el ID del usuario en la tabla 'users'
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($userId, 'id')],
            
            // La contraseña es OPCIONAL
            'password' => ['nullable', 'string', 'min:8', 'confirmed'], 
            
            // Reglas para StudentProfile
            'dni' => [
                'required', 
                'string', 
                'max:15', 
                // ✅ CORREGIDO: Ignoramos el ID del PERFIL en la tabla 'student_profiles' (clave 'id' por defecto)
                Rule::unique('student_profiles', 'dni')->ignore($studentProfileId, 'id'),
            ],
            'phone' => ['nullable', 'string', 'max:20'],
            'birth_date' => ['nullable', 'date'],
            'gender' => ['nullable', Rule::in(['masculino', 'femenino', 'otro'])],
            
            'emergency_contact' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            
            'code' => [
                'nullable', 
                'string', 
                'max:50', 
                // ✅ CORREGIDO: Ignoramos el ID del PERFIL en la tabla 'student_profiles'
                Rule::unique('student_profiles', 'code')->ignore($studentProfileId, 'id'),
            ],
            // ✅ ESTADO: Debe ser requerido y solo aceptar los valores definidos
            'status' => ['required', Rule::in(['activo', 'inactivo', 'suspendido'])],
        ];
    }
}