<?php

namespace LaravelEnso\Addresses\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use LaravelEnso\Addresses\Models\Postcode;

class ValidatePostcodeRequest extends FormRequest
{
    public function rules()
    {
        return [
            'country_id' => 'required|exists:countries,id',
            'postcode' => 'required|exists:postcodes,code',
        ];
    }

    public function withValidator($validator)
    {
        if ($this->postcodeNotFound()) {
            $attributes = new Collection(['country_id', 'postcode']);

            $validator->after(fn ($validator) => $attributes
                ->each(fn ($attribute) => $validator->errors()
                    ->add($attribute, 'Postcode not found')));
        }
    }

    private function postcodeNotFound(): bool
    {
        return $this->filled('country_id')
            && $this->filled('postcode')
            && Postcode::whereCountryId($this->get('country_id'))
                ->whereCode($this->get('postcode'))
                ->doesntExist();
    }
}
