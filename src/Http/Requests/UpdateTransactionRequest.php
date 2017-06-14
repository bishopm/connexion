<?php

namespace Bishopm\Connexion\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransactionRequest extends FormRequest
{
    public function rules()
    {
        return [
            'transactiondate' => 'required',
            'transactiontype' => 'required',
            'units' => 'required',
            'unitamount' => 'required',
            'book_id' => 'required'
        ];
    }

    public function authorize()
    {
        return true;
    }

}
