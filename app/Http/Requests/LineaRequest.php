<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LineaRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar esta solicitud.
     */
    public function authorize(): bool
    {
        return $this->user() && $this->user()->rol === 'CONSULTOR';
    }

    /**
     * Reglas de validación aplicadas a la línea comercial.
     */
    public function rules(): array
    {
        $lineaId = $this->route('linea') ? $this->route('linea')->id : null;

        return [
            'nombre' => [
                'required',
                'string',
                'max:120',
                Rule::unique('lineas', 'nombre')->ignore($lineaId),
            ],
            'descripcion' => ['nullable', 'string'],
            'activo' => ['sometimes', 'boolean'],
        ];
    }
}
