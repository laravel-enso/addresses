<?php

namespace LaravelEnso\Addresses\App\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Addresses\App\Http\Requests\ValidateAddressFetch;
use LaravelEnso\Addresses\App\Http\Resources\Address as Resource;
use LaravelEnso\Addresses\App\Models\Address;

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
