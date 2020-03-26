<?php

namespace LaravelEnso\Addresses\App\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Addresses\App\Forms\Builders\AddressForm;
use LaravelEnso\Addresses\App\Models\Address;

class Edit extends Controller
{
    public function __invoke(Address $address, AddressForm $form)
    {
        return ['form' => $form->edit($address)];
    }
}
