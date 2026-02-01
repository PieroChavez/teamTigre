<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Se asume que el acceso ya está controlado por middleware de admin
        return true; 
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // DATOS DEL USUARIO (Tabla: users)
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],

            // DATOS DEL PERFIL (Tabla: student_profiles)
            'code'              => ['nullable', 'string', 'max:50', 'unique:student_profiles,code'],
            'dni'               => ['nullable', 'string', 'max:15', 'unique:student_profiles,dni'],
            'phone'             => ['nullable', 'string', 'max:20'],
            'birth_date'        => ['nullable', 'date'],
            'gender'            => ['nullable', 'in:masculino,femenino,otro'],
            'emergency_contact' => ['nullable', 'string', 'max:255'],
            'notes'             => ['nullable', 'string'],
            'status'            => ['required', 'in:activo,inactivo,suspendido'],
        ];
    }

    /**
     * Personalizar los nombres de atributo para los mensajes de error.
     */
    public function attributes(): array
    {
        return [
            'name'              => 'Nombre Completo',
            'email'             => 'Correo Electrónico',
            'password'          => 'Contraseña',
            'code'              => 'Código de Alumno',
            'dni'               => 'DNI',
            'phone'             => 'Teléfono',
            'birth_date'        => 'Fecha de Nacimiento',
            'gender'            => 'Género',
            'emergency_contact' => 'Contacto de Emergencia',
            'status'            => 'Estado del Alumno',
        ];
    }
}