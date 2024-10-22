<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePresentacioneRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $presentacione = $this->route('presentacione');
        $caracteristicaId = $presentacione->caracteristica->id;

        return [
            'nombre' => 'required|max:60|unique:caracteristicas,nombre,' . $caracteristicaId,
            'descripcion' => 'nullable|max:255'
        ];
    }
}
