<?php

namespace LaravelEnso\Addresses\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Addresses\Models\Address;

class MakeShipping extends Controller
{
    public function __invoke(Address $address)
    {
        $address->toggleShipping();
    }
}
