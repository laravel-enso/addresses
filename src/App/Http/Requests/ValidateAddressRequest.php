<?php

namespace LaravelEnso\Addresses\App\Http\Requests;

use Illuminate\Validation\Rule;
use LaravelEnso\Countries\App\Models\Country;

class ValidateAddressRequest extends ValidateAddressFetch
{
    public function rules()
    {
        $country = Country::find($this->get('country_id'));
        $hasLocalities = $country->localities()->exists();
        $hasRegions = $country->regions()->exists();

        return parent::rules() + [
            'country_id' => 'required',
            'region_id' => ['nullable', 'exists:regions,id', $this->required($hasRegions)],
            'locality_id' => ['nullable', 'exists:localities,id', $this->required($hasLocalities)],
            'city' => ['nullable', 'string', 'max:255', $this->required(! $hasLocalities)],
            'street' => 'required|string|max:255',
            'is_default' => 'nullable|boolean',
            'additional' => 'nullable|string|max:255',
            'postal_area' => 'nullable',
            'obs' => 'nullable',
            'lat' => ['nullable', new Latitude()],
            'long' => ['nullable', new Longitude()],
        ];
    }

    private function required(bool $hasLocalities)
    {
        return Rule::requiredIf($hasLocalities);
    }
}
