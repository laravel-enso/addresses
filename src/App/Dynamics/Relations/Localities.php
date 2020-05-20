<?php

namespace LaravelEnso\Addresses\App\Dynamics\Relations;

use Closure;
use LaravelEnso\Addresses\App\Models\Locality;
use LaravelEnso\Addresses\App\Models\Region;
use LaravelEnso\DynamicMethods\App\Contracts\Method;

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
