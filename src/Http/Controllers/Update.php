<?php

namespace LaravelEnso\Addresses\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Addresses\Http\Requests\ValidateAddressRequest;
use LaravelEnso\Addresses\Models\Address;

class Update extends Controller
{
    public function __invoke(ValidateAddressRequest $request, Address $address)
    {
        $address->update($request->validated());

        return ['message' => __('The address has been successfully updated')];
    }
}
