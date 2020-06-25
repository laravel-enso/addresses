<?php

namespace LaravelEnso\Addresses\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Addresses\Http\Requests\ValidateAddressFetch;
use LaravelEnso\Addresses\Http\Resources\Address as Resource;
use LaravelEnso\Addresses\Models\Address;

class Index extends Controller
{
    public function __invoke(ValidateAddressFetch $request)
    {
        return Resource::collection(
            Address::with('country', 'region', 'locality')
                ->for($request->get('addressable_id'), $request->get('addressable_type'))
                ->ordered()
                ->get()
        );
    }
}
