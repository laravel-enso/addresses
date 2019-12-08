<?php

namespace LaravelEnso\Addresses\app\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Addresses\App\Http\Requests\ValidateAddressFetch;
use LaravelEnso\Addresses\app\Http\Resources\Address as Resource;
use LaravelEnso\Addresses\app\Models\Address;

class Index extends Controller
{
    public function __invoke(ValidateAddressFetch $request)
    {
        return Resource::collection(
            Address::for($request->validated())
                ->ordered()
                ->get()
        );
    }
}
