<?php

namespace LaravelEnso\Addresses\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use LaravelEnso\Addresses\Models\Region;
use LaravelEnso\Countries\Models\Country;

class RegionFactory extends Factory
{
    protected $model = Region::class;

    public function definition()
    {
        return [
            'country_id'   => Country::factory(),
            'abbreviation' => $this->faker->randomNumber(5),
            'name'         => $this->faker->word,
            'is_active'    => $this->faker->boolean,
        ];
    }
}
