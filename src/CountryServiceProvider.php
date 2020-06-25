<?php

namespace LaravelEnso\Addresses;

use Illuminate\Support\ServiceProvider;
use LaravelEnso\Addresses\DynamicRelations\Localities;
use LaravelEnso\Addresses\DynamicRelations\Regions;
use LaravelEnso\Countries\Models\Country;
use LaravelEnso\DynamicMethods\Services\Methods;

class CountryServiceProvider extends ServiceProvider
{
    public $methods = [
        Regions::class,
        Localities::class,
    ];

    public function boot()
    {
        Methods::bind(Country::class, $this->methods);
    }
}
