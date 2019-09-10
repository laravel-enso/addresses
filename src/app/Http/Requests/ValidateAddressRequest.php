<?php

namespace LaravelEnso\Addresses\App\Http\Requests;

class ValidateAddressRequest extends ValidateAddressFetch
{
    public function rules()
    {
        return parent::rules() + [
            'street' => 'required',
            'city' => 'required',
            'country_id' => 'required',
            'is_default' => 'nullable|boolean',
            'apartment' => 'nullable',
            'floor' => 'nullable',
            'entry' => 'nullable',
            'building' => 'nullable',
            'building_type' => 'nullable',
            'number' => 'nullable',
            'street_type' => 'nullable',
            'sub_administrative_area' => 'nullable',
            'administrative_area' => 'nullable',
            'postal_area' => 'nullable',
            'obs' => 'nullable',
            'lat' => ['nullable', new Latitude],
            'long' => ['nullable', new Longitude],
        ];
    }
}
