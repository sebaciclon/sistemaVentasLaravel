<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateProfileRequest extends FormRequest
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
        $user = $this->route('profile');
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable',
        ];
    }

    public function messages() {
        return [
            'name.required' => 'El campo NOMBRES es obligatorio.',
            'email.required' => 'El campo EMAIL es obligatorio.',
            'email.email' => 'El campo EMAIL tiene que tener un @.',
            'email.unique' => 'Ya existe el email ingresado.',
        ];
    }
}
