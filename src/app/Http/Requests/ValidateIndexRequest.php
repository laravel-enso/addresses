<?php

namespace LaravelEnso\Addresses\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use LaravelEnso\Addresses\app\Exceptions\AddressException;

class ValidateIndexRequest extends FormRequest
{
    public function authorize()
    {
        $this->checkParams();

        return true;
    }

    public function rules()
    {
        return [
            'addressable_id' => 'required',
            'addressable_type' => 'required|string',
        ];
    }

    private function checkParams()
    {
        if (! class_exists($this->get('addressable_type'))) {
            throw new AddressException(
                'The "addressable_type" property must be a valid model class'
            );
        }
    }
}
