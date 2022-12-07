<?php

namespace LaravelEnso\Addresses\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use LaravelEnso\Addresses\Models\Address;
use LaravelEnso\Addresses\Models\Locality;
use LaravelEnso\Addresses\Models\Region;
use LaravelEnso\Countries\Models\Country;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition()
    {
        return [
            'addressable_id'   => null,
            'addressable_type' => null,
            'country_id'       => null,
            'region_id'        => null,
            'locality_id'      => null,
            'city'             => null,
            'street'           => null,
            'additional'       => null,
            'postcode'         => null,
            'lat'              => null,
            'long'             => null,
            'notes'            => null,
            'is_default'       => true,
            'is_billing'       => true,
            'is_shipping'      => true,
        ];
    }

    public function test()
    {
        return $this->state(fn () => [
            'addressable_id' => $this->faker->randomNumber(5),
            'addressable_type' => $this->faker->word,
            'country_id' => Country::factory(),
            'region_id' => Region::factory(),
            'locality_id' => Locality::factory(),
            'city' => $this->faker->city,
            'street' => $this->faker->streetAddress,
            'additional' => null,
            'postcode' => $this->faker->postcode,
            'lat' => $this->faker->latitude,
            'long' => $this->faker->longitude,
            'notes' => $this->faker->realText(),
            'is_default' => $this->faker->boolean,
            'is_billing' => $this->faker->boolean,
            'is_shipping' => $this->faker->boolean,
        ]);
    }
}
