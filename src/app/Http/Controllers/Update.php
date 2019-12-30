<?php

namespace LaravelEnso\Addresses\App\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Addresses\App\Http\Requests\ValidateAddressRequest;
use LaravelEnso\Addresses\App\Models\Address;

class Update extends Controller
{
    public function __invoke(ValidateAddressRequest $request, Address $address)
    {
        $address->update($request->validated());

        return ['message' => __('The address has been successfully updated')];
    }
}
