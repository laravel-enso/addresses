<?php

namespace LaravelEnso\Addresses\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use LaravelEnso\Addresses\Models\Region;
use LaravelEnso\Addresses\Models\Township;

class TownshipFactory extends Factory
{
    protected $model = Township::class;

    public function definition()
    {
        return [
            'region_id' => Region::factory(),
            'name' => $this->faker->word,
        ];
    }
}
