<?php

namespace LaravelEnso\Addresses\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Addresses\Models\Address;

class Localize extends Controller
{
    public function __invoke(Address $address)
    {
        return $address->localize();
    }
}
