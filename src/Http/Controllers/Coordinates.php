<?php

namespace LaravelEnso\Addresses\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Addresses\Http\Requests\ValidateCoordinates;
use LaravelEnso\Addresses\Models\Address;

class Coordinates extends Controller
{
    public function __invoke(ValidateCoordinates $request, Address $address)
    {
        $address->update($request->validated());

        return ['message' => __('The address coordinates have been successfully updated')];
    }
}
