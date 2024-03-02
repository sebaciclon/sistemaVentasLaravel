<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeLoginRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required'
        ];
    }

    public function messages() {
        return [
            'email.required' => 'El campo CORREO ELECTRONICO es obligatorio.',
            'email.email' => 'El campo CORREO ELECTRONICO es de tipo email.',
            'password.required' => 'El campo CONTRASEÑA es obligatorio.',
        ];
    }
}
