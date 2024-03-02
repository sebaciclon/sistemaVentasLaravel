<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeCategoriaRequest extends FormRequest
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
            'nombre' => 'required|max:100|unique:categorias,nombre',
            'descripcion' => 'nullable|max:255'
        ];
    }

    public function messages() {
        return [
            'nombre.required' => 'El campo NOMBRE es obligatorio.',
            'nombre.max' => 'El campo NOMBRE tiene un maximo de 100 caracteres.',
            'nombre.unique' => 'Ya existe la categoría que intenta ingresar.',
            'descripcion.max' => 'El campo DESCRIPCION tiene un maximo de 255 caracteres.',
        ];
    }
}
