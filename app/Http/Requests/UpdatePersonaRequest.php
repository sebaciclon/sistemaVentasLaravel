<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePersonaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return TRUE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $persona = $this->route('persona');
        return [
            'nombre' => 'required|max:100',
            'direccion' => 'nullable|max:100',
            'telefono' => 'nullable|max:20'
        ];
    }

    public function messages() {
        return [
            'nombre.required' => 'El campo NOMBRE es obligatorio.',
            'nombre.max' => 'El campo NOMBRE tiene un maximo de 100 caracteres.',
            'nombre.unique' => 'Ya existe el nombre que intenta ingresar.',
            'direccion.max' => 'El campo DIRECCION tiene un maximo de 100 caracteres.',
            'telefono.max' => 'El campo TELEFONO tiene un maximo de 20 caracteres.',
        ];
    }
}
