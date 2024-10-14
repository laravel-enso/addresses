<?php

namespace LaravelEnso\Addresses\Http\Requests;

use Illuminate\Validation\Rule;
use LaravelEnso\Addresses\Models\Sector;
use LaravelEnso\Countries\Models\Country;

class ValidateAddressRequest extends ValidateAddressFetch
{
    public function rules()
    {
        $country = Country::find($this->get('country_id'));
        $hasLocalities = $country->localities()->exists();
        $hasRegions = $country->regions()->exists();
        $hasSectors = $hasLocalities && Sector::query()
            ->whereLocalityId($this->get('locality_id'))
            ->exists();

        return parent::rules() + [
            'country_id' => 'required',
            'region_id' => ['nullable', 'exists:regions,id', $this->required($hasRegions)],
            'locality_id' => ['nullable', 'exists:localities,id', $this->required($hasLocalities)],
            'sector_id' => ['nullable', 'exists:sectors,id', $this->required($hasSectors)],
            'city' => ['nullable', 'string', 'max:255', $this->required(! $hasLocalities)],
            'street' => 'required|string|max:255',
            'is_default' => 'required|boolean',
            'is_billing' => 'required|boolean',
            'is_shipping' => 'required|boolean',
            'additional' => 'nullable|string|max:255',
            'postcode' => 'nullable',
            'notes' => 'nullable',
            'lat' => ['nullable', new Latitude()],
            'long' => ['nullable', new Longitude()],
        ];
    }

    private function required(bool $hasLocalities)
    {
        return Rule::requiredIf($hasLocalities);
    }
}
