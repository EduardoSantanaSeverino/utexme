<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ExamenesRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'Nombre' => 'required|min:0|max:255',
            'Descripcion' => 'min:0|max:255',
            'Activo' => 'min:0|max:256',
        ];
    }
}
