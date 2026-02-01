<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInscripcionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // En un proyecto real, se usaría un Gate o una política:
        // return $this->user()->can('create', Inscripcion::class);
        return true; 
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            // Selects de Modelos (Relaciones)
            'alumno_id' => ['required', 'integer', Rule::exists('alumnos', 'id')],
            'categoria_id' => ['required', 'integer', Rule::exists('categorias', 'id')],
            'horario_id' => ['required', 'integer', Rule::exists('horarios', 'id')], 
            'plantilla_periodo_id' => ['required', 'integer', Rule::exists('plantilla_periodos', 'id'), 'required_if:fecha_inicio,null'],

            // Fechas
            'fecha_inicio' => ['required', 'date'],
            'fecha_fin' => ['required', 'date', 'after_or_equal:fecha_inicio'],

            // Estado y Datos Financieros (para la CuentaInscripcion)
            'estado' => ['required', 'string', Rule::in(['vigente', 'pendiente', 'retirado'])],
            
            // 🛠️ CORRECCIÓN: Cambiado 'concepto_pagos' (Laravel default) a 'conceptos_pago' (tu tabla real)
            'concepto_pago_id' => ['required', 'integer', Rule::exists('conceptos_pago', 'id')],
            
            'monto_total_inscripcion' => ['required', 'numeric', 'min:0.01'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            // MENSAJES DE REQUERIDO (Para abordar 'The alumno id field is required')
            'alumno_id.required' => 'Debe seleccionar un alumno para la inscripción.',
            'categoria_id.required' => 'Debe seleccionar la categoría o curso.',
            'horario_id.required' => 'Debe seleccionar un horario.',
            'plantilla_periodo_id.required' => 'Debe seleccionar el periodo de la inscripción.',
            'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
            'fecha_fin.required' => 'La fecha de fin es obligatoria.',
            'estado.required' => 'El estado de la inscripción es obligatorio.',
            'concepto_pago_id.required' => 'Debe seleccionar un concepto/plan de pagos.',
            'monto_total_inscripcion.required' => 'El monto total de la inscripción es obligatorio.',

            // MENSAJES DE EXISTENCIA (Integridad de datos)
            'alumno_id.exists' => 'El alumno seleccionado no es válido.',
            'categoria_id.exists' => 'La categoría/curso seleccionada no es válida.',
            'horario_id.exists' => 'El horario seleccionado no es válido.',
            'plantilla_periodo_id.exists' => 'El periodo seleccionado no es válido.',
            'concepto_pago_id.exists' => 'El plan de pagos/concepto seleccionado no es válido.',

            // MENSAJES DE REGLAS ESPECÍFICAS
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
            'estado.in' => 'El estado inicial seleccionado no es válido.',
            'monto_total_inscripcion.min' => 'El monto total debe ser mayor a 0.00.',
            'monto_total_inscripcion.numeric' => 'El monto total debe ser un valor numérico.',
        ];
    }
}