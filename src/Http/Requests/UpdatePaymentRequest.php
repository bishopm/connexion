<?php

namespace Bishopm\Connexion\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentRequest extends FormRequest
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
