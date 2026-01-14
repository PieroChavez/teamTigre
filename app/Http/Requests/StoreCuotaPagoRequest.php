<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCuotaPagoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        // El ID de la cuota a pagar viene de la URL ({cuota}), no del formulario.
        // Solo validamos los campos que vienen del formulario de pago (ver imagen).
        return [
            // ⚠️ NOTA: El formulario de la imagen pide "Seleccione una Inscripción".
            // Para pagar una cuota, generalmente necesitas el ID de la CUOTA.
            // Si tu formulario está diseñado para pagar una CUOTA ESPECÍFICA (como dice tu ruta),
            // NO NECESITAS ESTOS CAMPOS en el Form Request, ya que están validados por la ruta.
            
            // Si el formulario SÓLO está enviando lo que se ve en la imagen:
            // 1. Necesitas el ID de la inscripción (si la cuota se selecciona implícitamente).
            'inscripcion_id' => ['required', 'integer', 'exists:inscripciones,id'], // Si es la primera cuota.
            
            // 2. Tipo de pago (efectivo, tarjeta, etc.)
            'tipo_pago_id' => ['required', 'integer', 'exists:tipos_pago,id'],
            
            // 3. Monto
            'monto' => ['required', 'numeric', 'min:0.01'],
            
            // 4. Referencia
            'referencia' => ['nullable', 'string', 'max:255'],
        ];
    }
}