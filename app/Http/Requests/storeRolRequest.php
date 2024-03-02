<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeRolRequest extends FormRequest
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
            'name' => 'required|unique:roles,name',
            'permission' => 'required'
        ];
    }

    public function messages() {
        return [
            'name.required' => 'El campo NOMBRE DEL ROL es obligatorio.',
            'name.unique' => 'Ya existe el rol ingresado.',
            'permission.required' => 'Debe seleccionar algún permiso.',
        ];
    }
}
