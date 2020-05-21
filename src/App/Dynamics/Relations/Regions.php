<?php

namespace LaravelEnso\Addresses\App\Dynamics\Relations;

use Closure;
use LaravelEnso\Addresses\App\Models\Region;
use LaravelEnso\DynamicMethods\App\Contracts\Method;

class Regions implements Method
{
    public function name(): string
    {
        return 'regions';
    }

    public function closure(): Closure
    {
        return fn () => $this->hasMany(Region::class);
    }
}
