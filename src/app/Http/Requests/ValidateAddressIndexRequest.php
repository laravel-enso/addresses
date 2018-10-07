<?php

namespace LaravelEnso\AddressesManager\App\Http\Requests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use LaravelEnso\AddressesManager\app\Exceptions\AddressException;

class ValidateAddressIndexRequest extends FormRequest
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

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!class_exists($this->addressable_type)
                || !new $this->addressable_type instanceof Model) {
                throw new AddressException(
                    'The "addressable_type" property must be a valid model class'
                );
            }
        });
    }
}
