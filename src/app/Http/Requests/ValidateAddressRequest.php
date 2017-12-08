<?php

namespace LaravelEnso\AddressesManager\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateAddressRequest extends FormRequest
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
        $address = $this->route('address');

        if (request()->getMethod() == 'PATCH') {
            return config('addresses.validations.update');
        }

        return config('addresses.validations.create');
    }
}
