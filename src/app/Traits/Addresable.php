<?php
/**
 * Created by PhpStorm.
 * User: mihai
 * Date: 12/6/17
 * Time: 10:59 AM.
 */

namespace LaravelEnso\AddressesManager\app\Traits;

use LaravelEnso\AddressesManager\app\Models\Address;

trait Addresable
{
    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }
}
