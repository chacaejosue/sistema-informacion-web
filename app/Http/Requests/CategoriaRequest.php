<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoriaRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar esta solicitud.
     */
    public function authorize(): bool
    {
        return $this->user() && $this->user()->rol === 'CONSULTOR';
    }

    /**
     * Reglas de validación aplicadas a la categoría.
     */
    public function rules(): array
    {
        $categoriaId = $this->route('categoria') ? $this->route('categoria')->id : null;

        return [
            'nombre' => [
                'required',
                'string',
                'max:120',
                Rule::unique('categorias', 'nombre')->ignore($categoriaId),
            ],
            'descripcion' => ['nullable', 'string'],
            'activo' => ['sometimes', 'boolean'],
        ];
    }
}
