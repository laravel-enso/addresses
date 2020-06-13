<?php

namespace LaravelEnso\Addresses\App\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Addresses\App\Models\Address;

class Localize extends Controller
{
    public function __invoke(Address $address)
    {
        return $address->localize();
    }
}
