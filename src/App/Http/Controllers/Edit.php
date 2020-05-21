<?php

namespace LaravelEnso\Addresses\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LaravelEnso\Addresses\App\Forms\Builders\AddressForm;
use LaravelEnso\Addresses\App\Models\Address;

class Edit extends Controller
{
    public function __invoke(Request $request, Address $address, AddressForm $form)
    {
        return ['form' => $form->edit($address, $request->get('countryId'))];
    }
}
