<?php

namespace Bishopm\Connexion\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHouseholdRequest extends FormRequest
{
    public function rules()
    {
        return [
            'addressee' => 'required'
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'addressee.required' => 'This field is really important'
        ];
    }
}
