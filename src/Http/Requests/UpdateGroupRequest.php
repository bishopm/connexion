<?php

namespace Bishopm\Connexion\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGroupRequest extends FormRequest
{
    public function rules()
    {
        return [
            'groupname' => 'required',
            'slug' => 'required|unique:groups'
        ];
    }

    public function authorize()
    {
        return true;
    }

}
