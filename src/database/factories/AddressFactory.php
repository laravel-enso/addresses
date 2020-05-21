<?php

use Faker\Generator as Faker;
use Illuminate\Support\Facades\Config;
use LaravelEnso\Addresses\App\Models\Address;

$factory->define(Address::class, function (Faker $faker) {
    return [
        'addressable_id' => $faker->randomNumber(5),
        'addressable_type' => $faker->word,
        'country_id' => Config::get('enso.addresses.defaultCountryId'),
        'region_id' => null,
        'locality_id' => null,
        'city' => $faker->city,
        'street' => $faker->streetAddress,
        'additional' => null,
        'postcode' => $faker->postcode,
        'lat' => $faker->latitude,
        'long' => $faker->longitude,
        'notes' => $faker->realText(),
        'is_default' => true,
    ];
});
