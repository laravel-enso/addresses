<?php

namespace LaravelEnso\Addresses\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidatePostcodeRequest extends FormRequest
{
    public function rules()
    {
        return [
            'country_id' => 'required|exists:countries,id',
            'postcode' => 'required|exists:postcodes,code',
        ];
    }
}
