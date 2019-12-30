<?php

namespace LaravelEnso\Addresses\App\Forms\Builders;

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

    public function edit($address)
    {
        return $this->form->title('Edit')
            ->actions('update')
            ->edit($address);
    }
}
