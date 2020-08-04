<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TomadosRequest extends Request
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
            'Artist' => 'required|min:0|max:150',
            'Title' => 'required|min:0|max:150',
            'Description' => 'max:150',
            'CreateDate' => 'required|date',
            'ExibitDate' => 'required|date',
        ];
    }
}
