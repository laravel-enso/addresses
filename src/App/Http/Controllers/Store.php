<?php

namespace LaravelEnso\Addresses\App\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Addresses\App\Http\Requests\ValidateAddressRequest;
use LaravelEnso\Addresses\App\Models\Address;

class Store extends Controller
{
    public function __invoke(ValidateAddressRequest $request, Address $address)
    {
        $address->fill($request->validated());

        $address->is_default = $address->addressable->addresses()->doesntExist();

        $address->save();

        return ['message' => __('The address was successfully created')];
    }
}
