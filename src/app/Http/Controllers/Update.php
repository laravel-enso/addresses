<?php

namespace LaravelEnso\Addresses\app\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Addresses\app\Models\Address;
use LaravelEnso\Addresses\App\Http\Requests\ValidateAddressRequest;

class Update extends Controller
{
    public function __invoke(ValidateAddressRequest $request, Address $address)
    {
        $address->update($request->validated());

        return ['message' => __('The address has been successfully updated')];
    }
}
