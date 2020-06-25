<?php

namespace LaravelEnso\Addresses\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LaravelEnso\Addresses\Forms\Builders\AddressForm;
use LaravelEnso\Addresses\Models\Address;

class Edit extends Controller
{
    public function __invoke(Request $request, Address $address, AddressForm $form)
    {
        return ['form' => $form->edit($address, $request->get('countryId'))];
    }
}
