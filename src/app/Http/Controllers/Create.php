<?php

namespace LaravelEnso\Addresses\app\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Addresses\app\Forms\Builders\AddressForm;

class Create extends Controller
{
    public function __invoke(AddressForm $form)
    {
        return ['form' => $form->create()];
    }
}
