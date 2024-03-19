<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeProductoRequest extends FormRequest
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
            'nombre' => 'required|max:100|',
            'descripcion' => 'nullable|max:255',
            //'codigo' => 'required|integer|unique:productos,codigo',
            'codigo' => 'nullable|integer|unique:productos,codigo',
            'marca' => 'nullable|max:255',
            'fecha_vencimiento' => 'nullable|date|max:20',
            'img_path' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'categoria_id' => 'required|integer|exists:categorias,id',
            
        ];
    }

    public function messages() {
        return [
            'nombre.required' => 'El campo NOMBRE es obligatorio.',
            'nombre.max' => 'El campo NOMBRE tiene un maximo de 100 caracteres.',
            'descripcion.max' => 'El campo DESCRIPCION tiene un maximo de 255 caracteres.',
            
            //'codigo.max' => 'El campo CODIGO tiene un maximo de 100 caracteres.',
            'codigo.unique' => 'Ya existe el codigo que intenta ingresar.',
            'codigo.integer' => 'El campo CODIGO sólo acepta valores enteros.',
            'marca.max' => 'El campo MARCA tiene un maximo de 255 caracteres.',
            'fecha_vencimiento.date' => 'El campo FECHA VENCIMIENTO es de tipo fecha.',
            'fecha_vencimiento.max' => 'El campo MARCA tiene un maximo de 20 caracteres.',
            'img_path.image' => 'El campo IMAGEN sólo acepta imagenes.',
            'img_path.mimes' => 'El campo IMAGEN sólo acepta formatos png, jpg o jpeg.',
            'categoria_id.required' => 'El campo CATEGORIA es obligatorio.',
            'categoria_id.integer' => 'El campo CATEGORIA sólo acepta números enteros.',

            
        ];
    }
}
