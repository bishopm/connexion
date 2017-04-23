<?php

namespace Bishopm\Connexion\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGroupRequest extends FormRequest
{
    public function rules()
    {
        return [
            'groupname' => 'required'
        ];
    }

    public function authorize()
    {
        return true;
    }

}
