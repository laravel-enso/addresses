<?php

namespace LaravelEnso\Addresses\App\Http\Controllers;

use App\Http\Controllers\Controller;
use LaravelEnso\Addresses\App\Models\Region;
use LaravelEnso\Select\App\Traits\OptionsBuilder;

class CountyOptions extends Controller
{
    use OptionsBuilder;

    protected $queryAttributes = ['name', 'abbreviation'];

    public function query()
    {
        return Region::active();
    }
}
