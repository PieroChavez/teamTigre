<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // Asegúrate de importar Rule

class StorePagoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Generalmente, solo el usuario autenticado (cajero/administrador) puede registrar pagos.
        return auth()->check(); 
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // Identifica a qué inscripción se aplica el pago.
            'inscripcion_id' => [
                'required', 
                'integer', 
                // Asegura que la inscripción exista y, opcionalmente, esté vigente
                Rule::exists('inscripciones', 'id') 
            ],
            
            // ✅ CORRECCIÓN 1: Usamos 'monto' para coincidir con la vista y el controlador.
            // Monto real que el usuario está entregando.
            'monto' => [
                'required', 
                'numeric', 
                'min:0.01' // Asegura que el pago sea positivo
            ],
            
            // El tipo de pago utilizado (FK al modelo TipoPago).
            'tipo_pago_id' => [
                'required', 
                'exists:tipos_pago,id' // Asegura que el tipo de pago exista
            ],
            
            // Campo opcional para referencia de transferencia, número de cheque, etc.
            'referencia' => [
                'nullable', 
                'string', 
                'max:255'
            ],
            
            // ❌ CORRECCIÓN 2: ELIMINAMOS 'alumno_id' de las reglas de validación.
            // El controlador lo obtendrá a partir del 'inscripcion_id'.
        ];
    }
    
    /**
     * Personaliza los mensajes de error.
     */
    public function messages(): array
    {
        return [
            'inscripcion_id.required' => 'Debe seleccionar la inscripción a la que se aplica el pago.',
            'inscripcion_id.exists' => 'La inscripción seleccionada no es válida.',
            // ✅ Usamos 'monto' en el mensaje
            'monto.required' => 'El monto del pago es obligatorio.',
            'monto.numeric' => 'El monto del pago debe ser un número.',
            'monto.min' => 'El pago debe ser por un monto superior a 0.01.',
            'tipo_pago_id.required' => 'Debe seleccionar un método de pago.',
            'tipo_pago_id.exists' => 'El método de pago seleccionado no es válido.',
        ];
    }
}