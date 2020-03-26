<?php

namespace LaravelEnso\Addresses\App\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Addresses\App\Forms\Builders\AddressForm;

class Create extends Controller
{
    public function __invoke(AddressForm $form)
    {
        return ['form' => $form->create()];
    }
}
