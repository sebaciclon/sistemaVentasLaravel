<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeUsuarioRequest extends FormRequest
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8|same:password_confirm',
            'role' => 'required|exists:roles,name'
        ];
    }
    

    public function messages() {
        return [
            'name.required' => 'El campo NOMBRE DEL USUARIO es obligatorio.',
            'name.max' => 'El campo NOMBRE DEL USUARIO tiene un maximo de 255 caracteres.',
            'email.required' => 'El campo EMAIL es obligatorio.',
            'email.email' => 'El campo EMAIL tiene que tener un @.',
            'email.max' => 'El campo EMAIL tiene un maximo de 255 caracteres.',
            'email.unique' => 'Ya existe el email ingresado.',
            'password.required' => 'El campo CONTRASEÑA es obligatorio.',
            'password.min' => 'El campo CONTRASEÑA debe tener al menos 8 caracteres.',
            'password.same' => 'las CONTRASEÑAS no coinciden.',
            'role.required' => 'El campo SELECCIONE UN ROL es obligatorio.',


           
        ];
    }
}
