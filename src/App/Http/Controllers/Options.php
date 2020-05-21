<?php

namespace LaravelEnso\Addresses\App\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Addresses\App\Http\Resources\OneLiner;
use LaravelEnso\Addresses\App\Models\Address;
use LaravelEnso\Select\App\Traits\OptionsBuilder;

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
