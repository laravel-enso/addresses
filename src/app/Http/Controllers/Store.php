<?php

namespace LaravelEnso\Addresses\app\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Addresses\app\Models\Address;
use LaravelEnso\Addresses\App\Http\Requests\ValidateAddressRequest;

class Store extends Controller
{
    public function __invoke(ValidateAddressRequest $request, Address $address)
    {
        tap($address)->fill($request->validated())
            ->save();

        return [
            'message' => __('The address was successfully created'),
        ];
    }
}
