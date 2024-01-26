<?php

namespace LaravelEnso\Addresses\Dynamics\Relations\Country;

use Closure;
use LaravelEnso\Addresses\Models\Region;
use LaravelEnso\Countries\Models\Country;
use LaravelEnso\DynamicMethods\Contracts\Relation;

class Regions implements Relation
{
    public function bindTo(): array
    {
        return [Country::class];
    }

    public function name(): string
    {
        return 'regions';
    }

    public function closure(): Closure
    {
        return fn (Country $country) => $country->hasMany(Region::class);
    }
}
