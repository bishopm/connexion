<?php

namespace bishopm\base\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRatingRequest extends FormRequest
{
    public function rules()
    {
        return [
            'rating' => 'required',
            'group_id' => 'required'
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
