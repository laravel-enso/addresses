<?php

namespace LaravelEnso\Addresses\Dynamics\Relations\User;

use Closure;
use LaravelEnso\Addresses\Models\Address;
use LaravelEnso\DynamicMethods\Contracts\Method;

class Addresses implements Method
{
    public function name(): string
    {
        return 'addresses';
    }

    public function closure(): Closure
    {
        return fn () => $this->hasMany(Address::class, 'created_by');
    }
}
