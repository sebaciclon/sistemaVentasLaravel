<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeCompraRequest extends FormRequest
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
            //'proveedor_id' => 'required|exists:proveedors,id',
            //'comprobante_id' => 'required|exists:comprobantes,id',
            //'nro_comprobante' => 'required|max:255|unique:compras,nro_comprobante',
            'fecha_hora1' => 'required',
            'total' => 'required',
        ];
    }

    public function messages() {
        return [
            'proveedor_id.required' => 'El campo PROVEEDOR es obligatorio.',
            'comprobante_id.required' => 'El campo TIPO DE COMPROBANTE es obligatorio.',
            'nro_comprobante.max' => 'El campo N° COMPROBANTE tiene un maximo de 255 caracteres.',
            'nro_comprobante.unique' => 'Ya existe el número de comprobante que intenta ingresar.',
            'nro_comprobante.required' => 'El campo N° DE COMPROBANTE es obligatorio.',
        ];
    }
}
