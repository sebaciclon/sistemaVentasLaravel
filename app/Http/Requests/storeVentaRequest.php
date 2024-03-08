<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeVentaRequest extends FormRequest
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
            //'cliente_id' => 'required|exists:clientes,id',
            'user_id' => 'required|exists:users,id',
            //'comprobante_id' => 'required|exists:comprobantes,id',
            //'nro_comprobante' => 'required|max:255|unique:ventas,nro_comprobante',
            
            'fecha_hora1' => 'required',
            'total' => 'required',
        ];
    }

    public function messages() {
        return [
            'cliente_id.required' => 'El campo CLIENTE es obligatorio.',
            'user_id.required' => 'El campo USUARIO es obligatorio.',
            'comprobante_id.required' => 'El campo TIPO DE COMPROBANTE es obligatorio.',
            'nro_comprobante.max' => 'El campo N° COMPROBANTE tiene un maximo de 255 caracteres.',
            'nro_comprobante.unique' => 'Ya existe el número de comprobante que intenta ingresar.',
            'nro_comprobante.required' => 'El campo N° DE COMPROBANTE es obligatorio.',
            'total.required' => 'El campo TOTAL es obligatorio.',
        ];
    }
}
