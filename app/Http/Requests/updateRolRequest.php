<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateRolRequest extends FormRequest
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
            
                'name' => 'required',
                'permission' => 'required'
            
        ];
    }

    public function messages() {
        return [
            'name.required' => 'El campo NOMBRE DEL ROL es obligatorio.',
            
            'permission.required' => 'Debe sellecionar algún permiso.',
        ];
    }
}
