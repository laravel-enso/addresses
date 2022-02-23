<?php

namespace LaravelEnso\Addresses\Forms\Builders;

use Illuminate\Support\Facades\Config;
use LaravelEnso\Addresses\Models\Address as Model;
use LaravelEnso\Countries\Models\Country;
use LaravelEnso\Forms\Services\Form;

class Address
{
    protected const TemplatePath = __DIR__.'/../Templates/address.json';

    protected Form $form;

    public function __construct()
    {
        $this->form = (new Form($this->templatePath()));
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

    public function edit(Model $address, ?int $countryId)
    {
        if ($countryId) {
            $address = new Model([
                'id' => $address->id,
                'country_id' => $countryId,
                'is_default' => $address->is_default,
            ]);
        }

        return $this->prepare($address->country)
            ->title('Edit')
            ->actions('update')
            ->edit($address);
    }

    protected function templatePath(): string
    {
        return self::TemplatePath;
    }

    private function prepare(Country $country): Form
    {
        $hasLocalities = $country->localities()->exists();
        $regions = $country->regions()->active()->get(['name', 'id']);
        $regionLabel = $country->regionLabel();

        return $this->form->value('country_id', $country->id)
            ->options('region_id', $regions)
            ->label('region_id', $regionLabel)
            ->columns('city', $regions->isEmpty() ? 1 : 2)
            ->meta('region_id', 'hidden', $regions->isEmpty())
            ->meta('locality_id', 'hidden', ! $hasLocalities)
            ->meta('city', 'hidden', $hasLocalities);
    }
}
