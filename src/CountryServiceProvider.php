<?php

namespace LaravelEnso\Addresses;

use Illuminate\Support\ServiceProvider;
use LaravelEnso\Addresses\Dynamics\Relations\Country\Localities;
use LaravelEnso\Addresses\Dynamics\Relations\Country\Regions;
use LaravelEnso\Countries\Models\Country;
use LaravelEnso\DynamicMethods\Services\Methods;

class CountryServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Methods::bind(Country::class, [Regions::class, Localities::class]);
    }
}
