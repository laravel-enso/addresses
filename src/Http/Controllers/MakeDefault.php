<?php

namespace LaravelEnso\Addresses\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Addresses\Models\Address;

class MakeDefault extends Controller
{
    public function __invoke(Address $address)
    {
        if (! $address->isDefault()) {
            $address->makeDefault();
        }
    }
}
