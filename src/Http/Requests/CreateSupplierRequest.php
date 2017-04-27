<?php

namespace Bishopm\Connexion\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSupplierRequest extends FormRequest
{
    public function rules()
    {
        return [
            'supplier' => 'required'
        ];
    }

    public function authorize()
    {
        return true;
    }

}
