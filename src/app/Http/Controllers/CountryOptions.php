<?php

namespace LaravelEnso\Addresses\app\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Addresses\app\Models\Country;
use LaravelEnso\Select\app\Traits\OptionsBuilder;

class CountryOptions extends Controller
{
    use OptionsBuilder;

    protected $model = Country::class;
}
