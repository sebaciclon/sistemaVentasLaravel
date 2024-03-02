<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateCategoriaRequest extends FormRequest
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
        //$categoria = $this->route('categoria');
        //$categoriaId = $categoria->id;
        return [
            'nombre' => 'required|max:100',
            'descripcion' => 'nullable|max:255'
        ];
    }

    public function messages() {
        return [
            'nombre.required' => 'El campo NOMBRE es obligatorio.',
            'nombre.max' => 'El campo NOMBRE tiene un maximo de 100 caracteres.',
            
            'descripcion.max' => 'El campo DESCRIPCION tiene un maximo de 255 caracteres.',
        ];
    }
}
