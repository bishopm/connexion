<?php

namespace Bishopm\Connexion\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function rules()
    {
        return [
            'body' => 'required',
            'user_id' => 'required'
        ];
    }

    public function authorize()
    {
        return true;
    }

}
