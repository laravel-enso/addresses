<?php

namespace LaravelEnso\Addresses\app\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Addresses\app\Models\Address;
use LaravelEnso\Addresses\app\Forms\Builders\AddressForm;

class Edit extends Controller
{
    public function __invoke(Address $address, AddressForm $form)
    {
        return ['form' => $form->edit($address)];
    }
}
