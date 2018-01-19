<?php

namespace LaravelEnso\AddressesManager\app\Http\Controllers;

use App\Http\Controllers\Controller;
use LaravelEnso\Select\app\Traits\OptionsBuilder;
use LaravelEnso\AddressesManager\app\Models\Country;

class CountriesSelectController extends Controller
{
    use OptionsBuilder;

    protected $class = Country::class;
}
