<?php

namespace LaravelEnso\Addresses\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Addresses\Models\Address;

class MakeBilling extends Controller
{
    public function __invoke(Address $address)
    {
        $address->toggleBilling();
    }
}
