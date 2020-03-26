<?php

namespace LaravelEnso\Addresses\App\Forms\Builders;

use LaravelEnso\Addresses\App\Models\Address;
use LaravelEnso\Forms\App\Services\Form;

class AddressForm
{
    protected const TemplatePath = __DIR__.'/../Templates/address.json';

    protected Form $form;

    public function __construct()
    {
        $this->form = (new Form(static::TemplatePath));
    }

    public function create()
    {
        return $this->form->title('Create')
            ->actions('store')
            ->create();
    }

    public function edit(Address $address)
    {
        return $this->form->title('Edit')
            ->actions('update')
            ->edit($address);
    }
}
