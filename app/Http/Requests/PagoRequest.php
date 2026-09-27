<?php

namespace App\Http\Requests;

use App\Models\Venta;
use Illuminate\Foundation\Http\FormRequest;

class PagoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && in_array($this->user()->rol, ['CONSULTOR', 'COLABORADOR']);
    }

    public function rules(): array
    {
        $venta = Venta::find($this->input('venta_id'));
        $maxMonto = $venta ? $venta->saldo_pendiente : 999999;

        return [
            'venta_id' => ['required', 'exists:ventas,id'],
            'monto' => ['required', 'numeric', 'min:0.01', "max:{$maxMonto}"],
            'metodo' => ['required', 'string', 'max:40'],
            'observacion' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'venta_id.required' => 'Debe seleccionar una venta para asociar el pago.',
            'monto.required' => 'El monto del pago es obligatorio.',
            'monto.min' => 'El monto del pago debe ser mayor a cero.',
            'monto.max' => 'El monto no puede exceder el saldo pendiente de la venta.',
            'metodo.required' => 'Debe indicar el método de pago (EFECTIVO, TRANSFERENCIA, etc.).',
        ];
    }
}
