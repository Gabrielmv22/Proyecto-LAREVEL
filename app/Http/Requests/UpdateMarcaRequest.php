<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMarcaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $marca = $this->route('marca');
        $caracteristicaId = $marca->caracteristica->id;

        return [
            'nombre' => 'required|max:60|unique:caracteristicas,nombre,' . $caracteristicaId,
            'descripcion' => 'nullable|max:255',
        ];
    }
}
