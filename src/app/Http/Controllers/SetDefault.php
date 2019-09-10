<?php

namespace LaravelEnso\Addresses\app\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Addresses\app\Models\Address;

class SetDefault extends Controller
{
    public function __invoke(Address $address)
    {
        if (! $address->isDefault()) {
            $address->setDefault();
        }
    }
}
