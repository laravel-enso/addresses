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
            && $address->addressable->addresses()->notDefault()->exists()) {
            throw AddressException::removeDefault();
        }

        $address->delete();

        return ['message' => __('The address was deleted')];
    }
}
