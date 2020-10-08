<?php

namespace LaravelEnso\Addresses\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use LaravelEnso\Addresses\Models\Address;
use LaravelEnso\Countries\Models\Country;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition()
    {
        return [
            'addressable_id' => $this->faker->randomNumber(5),
            'addressable_type' => $this->faker->word,
            'country_id' => Country::inRandomOrder()->first()->id,
            'region_id' => null,
            'locality_id' => null,
            'city' => $this->faker->city,
            'street' => $this->faker->streetAddress,
            'additional' => null,
            'postcode' => $this->faker->postcode,
            'lat' => $this->faker->latitude,
            'long' => $this->faker->longitude,
            'notes' => $this->faker->realText(),
            'is_default' => true,
            'is_billing' => true,
            'is_shipping' => true,
        ];
    }
}
