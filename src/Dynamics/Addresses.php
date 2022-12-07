<?php

namespace LaravelEnso\Addresses\Dynamics;

use Closure;
use LaravelEnso\Addresses\Models\Address;
use LaravelEnso\DynamicMethods\Contracts\Relation;
use LaravelEnso\Users\Models\User;

class Addresses implements Relation
{
    public function bindTo(): array
    {
        return [User::class];
    }

    public function name(): string
    {
        return 'addresses';
    }

    public function closure(): Closure
    {
        return fn (User $user) => $user->hasMany(Address::class, 'created_by');
    }
}
