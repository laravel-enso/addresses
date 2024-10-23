<?php

namespace LaravelEnso\Addresses\Http\Controllers;

use App\Http\Controllers\Controller;
use LaravelEnso\Addresses\Http\Resources\Sector as Resource;
use LaravelEnso\Addresses\Models\Sector;
use LaravelEnso\Select\Traits\OptionsBuilder;

class Sectors extends Controller
{
    use OptionsBuilder;

    protected $model = Sector::class;
    protected $resource = Resource::class;
}
