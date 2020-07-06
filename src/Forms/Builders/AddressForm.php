<?php

namespace LaravelEnso\Addresses\Forms\Builders;

use Illuminate\Support\Facades\Config;
use LaravelEnso\Addresses\Models\Address;
use LaravelEnso\Countries\Models\Country;
use LaravelEnso\Forms\Services\Form;

class AddressForm
{
    protected const TemplatePath = __DIR__.'/../Templates/address.json';

    protected Form $form;

    public function __construct()
    {
        $this->form = (new Form(static::TemplatePath));
    }

    public function create(?int $countryId)
    {
        $countryId ??= Config::get('enso.addresses.defaultCountryId');
        $country = Country::find($countryId);

        return $this->prepare($country)
            ->title('Create')
            ->actions('store')
            ->create();
    }

    public function edit(Address $address, ?int $countryId)
    {
        if ($countryId) {
            $address = $this->empty($address, $countryId);
        }

        return $this->prepare($address->country)
            ->title('Edit')
            ->actions('update')
            ->edit($address);
    }

    private function prepare(Country $country): Form
    {
        $hasLocalities = $country->localities()->exists();
        $regions = $country->regions()->active()->get(['name', 'id']);
        $regionLabel = $country->regionLabel();

        return $this->form->value('country_id', $country->id)
            ->options('region_id', $regions)
            ->label('region_id', $regionLabel)
            ->columns('region_id', $regions->isEmpty() ? 2 : 1)
            ->meta('region_id', 'hidden', $regions->isEmpty())
            ->meta('locality_id', 'hidden', ! $hasLocalities)
            ->meta('city', 'hidden', $hasLocalities);
    }

    private function empty(Address $address, int $countryId): Address
    {
        $newAddress = new Address([
            'country_id' => $countryId,
            'is_default' => $address->is_default,
        ]);
        $newAddress->id = $address->id;

        return $newAddress;
    }
}
