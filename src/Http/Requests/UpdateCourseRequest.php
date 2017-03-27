<?php

namespace Bishopm\Connexion\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required',
            'category' => 'required',
            'description' => 'required|min:2'
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
