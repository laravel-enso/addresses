<?php

namespace LaravelEnso\Addresses\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Addresses\Exceptions\Address as Exception;
use LaravelEnso\Addresses\Models\Address;

class Destroy extends Controller
{
    public function __invoke(Address $address)
    {
        if ($address->isDefault() && $address->isNotSingle()) {
            throw Exception::cannotRemoveDefault();
        }

        $address->delete();

        return ['message' => __('The address was deleted')];
    }
}
