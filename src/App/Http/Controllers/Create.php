<?php

namespace LaravelEnso\Addresses\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LaravelEnso\Addresses\App\Forms\Builders\AddressForm;

class Create extends Controller
{
    public function __invoke(Request $request, AddressForm $form)
    {
        return ['form' => $form->create($request->get('countryId'))];
    }
}
