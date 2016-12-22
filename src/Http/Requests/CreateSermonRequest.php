<?php

namespace bishopm\base\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSermonRequest extends FormRequest
{
    public function rules()
    {
        return [
            'sermon' => 'required'
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
