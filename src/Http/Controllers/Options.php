<?php

namespace LaravelEnso\Addresses\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Addresses\Http\Resources\OneLiner;
use LaravelEnso\Addresses\Models\Address;
use LaravelEnso\Select\Traits\OptionsBuilder;

class Options extends Controller
{
    use OptionsBuilder;

    protected $resource = OneLiner::class;

    protected $queryAttributes = [
        'street', 'additional', 'locality.name', 'region.name',
    ];

    public function query()
    {
        return Address::with('region', 'locality')->ordered();
    }
}
