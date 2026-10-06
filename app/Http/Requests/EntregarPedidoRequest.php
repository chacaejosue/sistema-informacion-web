<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EntregarPedidoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() && in_array($this->user()->rol, ['CONSULTOR', 'COLABORADOR'], true);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'recibido_por' => ['required', 'string', 'max:150'],
            'observaciones_entrega' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
