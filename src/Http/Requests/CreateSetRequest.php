<?php

namespace Bishopm\Connexion\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSetRequest extends FormRequest
{
    public function rules()
    {
        return [
            'service_id'    => 'required',
            'servicedate'   =>  'required'
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
