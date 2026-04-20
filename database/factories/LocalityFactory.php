<?php

namespace LaravelEnso\Addresses\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use LaravelEnso\Addresses\Models\Locality;
use LaravelEnso\Addresses\Models\Region;
use LaravelEnso\Addresses\Models\Township;

class LocalityFactory extends Factory
{
    protected $model = Locality::class;

    public function definition()
    {
        return [
            'region_id'   => Region::factory(),
            'township_id' => Township::factory(),
            'name'        => $this->faker->word,
            'is_active'   => $this->faker->boolean,
        ];
    }
}
