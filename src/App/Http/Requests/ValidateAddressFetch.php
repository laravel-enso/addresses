<?php

namespace LaravelEnso\Addresses\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateAddressFetch extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'addressable_id' => 'required',
            'addressable_type' => 'required|string',
        ];
    }
}
