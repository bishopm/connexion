<?php

namespace Bishopm\Connexion\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStatisticRequest extends FormRequest
{
    public function rules()
    {
        return [
            'statdate' => 'required',
            'attendance' => 'integer|required',
            'servicetime' => 'required'
        ];
    }

    public function authorize()
    {
        return true;
    }

}
