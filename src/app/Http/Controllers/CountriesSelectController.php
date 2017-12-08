<?php

namespace LaravelEnso\AddressesManager\app\Http\Controllers;

use App\Http\Controllers\Controller;
use LaravelEnso\AddressesManager\app\Models\Country;
use LaravelEnso\Select\app\Traits\SelectListBuilder;

class CountriesSelectController extends Controller
{
    use SelectListBuilder;

    protected $selectSourceClass = Country::class;
}
