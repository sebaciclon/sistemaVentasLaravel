<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeActualizacionPreciosRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'porcentaje' => 'required|numeric|min:0'
        ];
    }

    public function messages() {
        return [
            'porcentaje.required' => 'El campo PORCENTAJE DE ACTUALIZACION es obligatorio.',
            'porcentaje.numeric' => 'El campo PORCENTAJE DE ACTUALIZACION sólo acepta valores numéricos.',
            'porcentaje.min' => 'El campo PORCENTAJE DE ACTUALIZACION no acepta valores negativos.',
        ];
    }
}
