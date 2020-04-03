<?php

namespace LaravelEnso\Addresses\App\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Addresses\App\Exceptions\Address as Exception;
use LaravelEnso\Addresses\App\Http\Requests\ValidateAddressRequest;
use LaravelEnso\Addresses\App\Models\Address;

class Store extends Controller
{
    public function __invoke(ValidateAddressRequest $request, Address $address)
    {
        $address->fill($request->validated());

        if (! $address->hasMultiAddressSupport() && $this->hasAddress($address)) {
            throw Exception::cannotHaveMultipleAddresses();
        }

        $address->is_default = $address->addressable->address()->doesntExist();

        $address->save();

        return ['message' => __('The address was successfully created')];
    }

    private function hasAddress(Address $address): bool
    {
        return $address->addressable->address()->exists();
    }
}
