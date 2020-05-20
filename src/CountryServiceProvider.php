<?php

namespace LaravelEnso\Addresses;

use Illuminate\Support\ServiceProvider;
use LaravelEnso\Addresses\App\Dynamics\Relations\Localities;
use LaravelEnso\Addresses\App\Dynamics\Relations\Regions;
use LaravelEnso\DynamicMethods\App\Services\Methods;
use LaravelEnso\Countries\App\Models\Country;

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
