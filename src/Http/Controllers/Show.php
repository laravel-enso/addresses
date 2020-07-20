<?php

namespace LaravelEnso\Addresses\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Addresses\Http\Resources\Address as Resource;
use LaravelEnso\Addresses\Models\Address;

class Show extends Controller
{
    public function __invoke(Address $address)
    {
        return new Resource($address->load('country', 'region', 'locality'));
    }
}
