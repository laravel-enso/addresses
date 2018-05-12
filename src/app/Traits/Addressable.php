<?php

namespace LaravelEnso\AddressesManager\app\Traits;

use LaravelEnso\AddressesManager\app\Models\Address;

trait Addressable
{
    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function defaultAddress()
    {
        return $this->addresses()
            ->whereIsDefault(true)
            ->first();
    }
}
