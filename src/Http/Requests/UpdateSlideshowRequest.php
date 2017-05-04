<?php

namespace Bishopm\Connexion\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSlideshowRequest extends FormRequest
{
    public function rules()
    {
        return [
            'slideshow' => 'required',
            'height'=>'required',
            'width'=>'required',
            'duration'=>'required'
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
