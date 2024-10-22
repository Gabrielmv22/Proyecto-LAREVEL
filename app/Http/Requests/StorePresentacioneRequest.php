<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePresentacioneRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|max:60|unique:caracteristicas,nombre',
            'descripcion' => 'nullable|max:255'
        ];
    }
}
