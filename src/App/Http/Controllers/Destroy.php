<?php

namespace LaravelEnso\Addresses\App\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Addresses\App\Exceptions\Address as Exception;
use LaravelEnso\Addresses\App\Models\Address;

class Destroy extends Controller
{
    public function __invoke(Address $address)
    {
        if ($address->isDefault()
            && $address->addressable->addresses()->notDefault()->exists()) {
            throw Exception::cannotRemoveDefault();
        }

        $address->delete();

        return ['message' => __('The address was deleted')];
    }
}
