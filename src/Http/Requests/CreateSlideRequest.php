<?php

namespace Bishopm\Connexion\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSlideRequest extends FormRequest
{
    public function rules()
    {
        return [
            'slideshowname' => 'required',
            'image'=>'required'
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
