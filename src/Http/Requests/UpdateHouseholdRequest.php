<?php

namespace Bishopm\Connexion\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHouseholdRequest extends FormRequest
{
    public function rules()
    {
        return [
            'addressee' => 'required',
            'sortsurname' => 'required'
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'addressee.required' => 'You must enter the addressee name - eg: Mary and John Smith',
            'sortsurname.required' => 'Please add one family surname which will be used for sorting purposes'
        ];
    }
}
