<?php

namespace LaravelEnso\Addresses\DynamicRelations;

use Closure;
use LaravelEnso\Addresses\Models\Region;
use LaravelEnso\DynamicMethods\Contracts\Method;

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
