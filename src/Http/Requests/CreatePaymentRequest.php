<?php

namespace Bishopm\Connexion\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePaymentRequest extends FormRequest
{
    public function rules()
    {
        return [
            'paymentdate' => 'required',
            'pgnumber'=>'required',
            'amount'=>'required'
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
