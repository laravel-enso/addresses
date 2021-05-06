<?php

namespace LaravelEnso\Addresses\Dynamics\Relations\Country;

use Closure;
use LaravelEnso\Addresses\Models\Locality;
use LaravelEnso\Addresses\Models\Region;
use LaravelEnso\DynamicMethods\Contracts\Method;

class Localities implements Method
{
    public function name(): string
    {
        return 'localities';
    }

    public function closure(): Closure
    {
        return fn () => $this->hasManyThrough(Locality::class, Region::class);
    }
}
