<?php

namespace LaravelEnso\AddressesManager\app\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Select\app\Traits\OptionsBuilder;
use LaravelEnso\AddressesManager\app\Models\Country;

class CountriesSelectController extends Controller
{
    use OptionsBuilder;

    protected $model = Country::class;
}
