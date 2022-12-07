<?php

namespace LaravelEnso\Addresses\Dynamics;

use Closure;
use LaravelEnso\Addresses\Models\Locality;
use LaravelEnso\Addresses\Models\Region;
use LaravelEnso\Countries\Models\Country;
use LaravelEnso\DynamicMethods\Contracts\Relation;

class Localities implements Relation
{
    public function bindTo(): array
    {
        return [Country::class];
    }

    public function name(): string
    {
        return 'localities';
    }

    public function closure(): Closure
    {
        return fn (Country $country) => $country
            ->hasManyThrough(Locality::class, Region::class);
    }
}
