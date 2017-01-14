<?php

namespace bishopm\base\Http\Requests;

use App\Http\Requests\Request;

class SetsRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'service_id'	=> 'required',
            'servicedate'   =>  'required'
        ];
    }
}
