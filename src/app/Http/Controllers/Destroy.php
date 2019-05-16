<?php

namespace LaravelEnso\Addresses\app\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Addresses\app\Models\Address;
use LaravelEnso\Addresses\app\Exceptions\AddressException;

class Destroy extends Controller
{
    public function __invoke(Address $address)
    {
        if ($address->isDefault()
            && $address->addressable->addresses()->notDefault()->count() > 0) {
            throw new AddressException(__(
                'You cannot delete the default address while having secondary addresses
            '));
        }

        $address->delete();

        return ['message' => __('The address was deleted')];
    }
}
