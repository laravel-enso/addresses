<?php

namespace LaravelEnso\Addresses\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LaravelEnso\Addresses\Forms\Builders\Address as Form;

class Create extends Controller
{
    public function __invoke(Request $request, Form $form)
    {
        return ['form' => $form->create($request->get('countryId'))];
    }
}
