<?php

namespace LaravelEnso\Addresses\App\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Addresses\App\Models\Address;

class MakeDefault extends Controller
{
    public function __invoke(Address $address)
    {
        if (! $address->isDefault()) {
            $address->makeDefault();
        }
    }
}
