<?php

namespace LaravelEnso\AddressesManager\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use LaravelEnso\AddressesManager\app\Exceptions\AddressException;

class ValidateAddressRequest extends FormRequest
{
    public function authorize()
    {
        $this->checkParams();

        return true;
    }

    public function rules()
    {
        $rules = [
            'addressable_id'   => 'required',
            'addressable_type' => 'required|string',
        ];

        return $this->method() === 'GET'
            ? $rules
            : $rules + [
                'street'     => 'required',
                'city'       => 'required',
                'country_id' => 'required',
            ];
    }

    private function checkParams()
    {
        if (!class_exists($this->get('addressable_type'))) {
            throw new AddressException(
                'The "addressable_type" property must be a valid model class'
            );
        }
    }
}
