<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VentaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && in_array($this->user()->rol, ['CONSULTOR', 'COLABORADOR']);
    }

    public function rules(): array
    {
        return [
            'cliente_id' => ['required', 'exists:clientes,id'],
            'pedido_id' => ['nullable', 'exists:pedidos,id'],
            'forma_pago' => ['required', 'string', Rule::in(['CONTADO', 'CREDITO'])],
            'descuento' => ['nullable', 'numeric', 'min:0'],
            'detalles' => ['required', 'array', 'min:1'],
            'detalles.*.producto_id' => ['required', 'exists:productos,id'],
            'detalles.*.cantidad' => ['required', 'integer', 'min:1'],
            'detalles.*.precio_unitario' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'cliente_id.required' => 'Debe seleccionar un cliente para la venta.',
            'forma_pago.required' => 'Debe seleccionar la forma de pago (CONTADO o CREDITO).',
            'detalles.required' => 'Debe incluir al menos un producto en la venta.',
            'detalles.*.cantidad.min' => 'La cantidad vendida debe ser mayor que cero.',
            'detalles.*.precio_unitario.min' => 'El precio unitario no puede ser negativo.',
        ];
    }
}
