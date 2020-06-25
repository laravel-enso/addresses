<?php

namespace LaravelEnso\Addresses\Http\Controllers;

use App\Http\Controllers\Controller;
use LaravelEnso\Addresses\Models\Region;
use LaravelEnso\Select\Traits\OptionsBuilder;

class Regions extends Controller
{
    use OptionsBuilder;

    protected $queryAttributes = ['name', 'abbreviation'];

    public function query()
    {
        return Region::active();
    }
}
