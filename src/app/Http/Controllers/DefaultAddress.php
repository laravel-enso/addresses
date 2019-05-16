<?php

namespace LaravelEnso\Addresses\app\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Addresses\app\Models\Address;

class DefaultAddress extends Controller
{
    public function __invoke(Address $address)
    {
        $address->setDefault();
    }
}
