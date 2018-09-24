<?php

namespace LaravelEnso\AddressesManager\app\Traits;

use LaravelEnso\AddressesManager\app\Models\Address;

trait Addresses
{
    public function addresses()
    {
        return $this->hasMany(Address::class, 'created_by');
    }
}
