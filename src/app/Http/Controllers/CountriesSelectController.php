<?php

namespace LaravelEnso\AddressesManager\app\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\AddressesManager\app\Models\Country;
use LaravelEnso\Select\app\Traits\OptionsBuilder;

class CountriesSelectController extends Controller
{
    use OptionsBuilder;

    protected $model = Country::class;
}
