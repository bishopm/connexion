<?php

namespace bishopm\base\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePreacherRequest extends FormRequest
{
    public function rules()
    {
        return [
            'firstname' => 'required',
            'surname' => 'required|min:2',
            'title' => 'required',
            'society_id' => 'required',
            'status' => 'required'
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
