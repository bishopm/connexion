<?php

namespace Bishopm\Connexion\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSetRequest extends FormRequest
{
    public function rules()
    {
        return [
            'servicetime'    => 'required',
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
