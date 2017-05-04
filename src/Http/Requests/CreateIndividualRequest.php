<?php

namespace Bishopm\Connexion\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateIndividualRequest extends FormRequest
{
    public function rules()
    {
        return [
            'firstname' => 'required',
            'surname' => 'required',
            'cellphone' => 'nullable|digits:10',
            'officephone' => 'nullable|numeric',
            'giving' => 'nullable|numeric',
            'email' => 'nullable|email'
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'cellphone.digits' => 'Cellphone number must be exactly 10 digits with no spaces or hyphens'
        ];
    }

}