<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProveedorRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar esta solicitud.
     */
    public function authorize(): bool
    {
        return $this->user() && $this->user()->rol === 'CONSULTOR';
    }

    /**
     * Reglas de validación aplicadas al proveedor.
     */
    public function rules(): array
    {
        $proveedorId = $this->route('proveedor') ? $this->route('proveedor')->id : null;

        return [
            'nombre' => [
                'required',
                'string',
                'max:150',
                Rule::unique('proveedores', 'nombre')->ignore($proveedorId),
            ],
            'telefono' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'sitio_web' => ['nullable', 'url', 'max:255'],
            'activo' => ['sometimes', 'boolean'],
        ];
    }
}
