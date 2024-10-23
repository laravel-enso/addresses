<?php

namespace LaravelEnso\Addresses\Http\Controllers;

use App\Http\Controllers\Controller;
use LaravelEnso\Addresses\Http\Resources\Locality as Resource;
use LaravelEnso\Addresses\Models\Locality;
use LaravelEnso\Select\Traits\OptionsBuilder;

class Localities extends Controller
{
    use OptionsBuilder;

    protected $queryAttributes = ['name', 'township_id'];
    protected $resource = Resource::class;

    public function query()
    {
        return Locality::with('township', 'sectors')->active();
    }
}
