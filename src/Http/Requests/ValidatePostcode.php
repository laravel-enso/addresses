<?php

namespace LaravelEnso\Addresses\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

class ValidatePostcode extends FormRequest
{
    public function rules()
    {
        return [
            'country_id' => 'required|exists:countries,id',
            'postcode'   => ['required', $this->valid()],
        ];
    }

    private function valid(): Exists
    {
        return Rule::exists('postcodes', 'code')
            ->where('country_id', $this->get('country_id'));
    }
}
