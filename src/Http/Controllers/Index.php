<?php

namespace LaravelEnso\Addresses\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Addresses\Http\Requests\ValidateAddressFetch;
use LaravelEnso\Addresses\Http\Responses\Index as Response;

class Index extends Controller
{
    public function __invoke(ValidateAddressFetch $request)
    {
        return new Response();
    }
}
