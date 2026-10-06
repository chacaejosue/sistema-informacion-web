<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ActualizarTipoCambioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->rol === 'CONSULTOR';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, string|Rule>>
     */
    public function rules(): array
    {
        return [
            'fuente' => ['required', Rule::in(['OFICIAL', 'MANUAL'])],
            'tasa_manual' => ['nullable', 'numeric', 'gt:0', 'max:999999', 'required_if:fuente,MANUAL'],
        ];
    }

    public function messages(): array
    {
        return [
            'tasa_manual.required_if' => 'Ingresa una tasa manual para activar esa fuente.',
            'tasa_manual.gt' => 'La tasa manual debe ser mayor que cero.',
        ];
    }
}
