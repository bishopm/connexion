<?php

namespace Bishopm\Connexion\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
    public function rules()
    {
        return [
            'jobtitle' => 'required',
            'startdate' => 'required',
            'hours' => 'integer|required',
            'leave' => 'integer|required'
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
        ];
    }
}
