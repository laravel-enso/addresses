<?php

namespace LaravelEnso\Addresses\app\Traits;

use LaravelEnso\Addresses\app\Models\Address;

trait Addresses
{
    public function addresses()
    {
        return $this->hasMany(Address::class, 'created_by');
    }
}
