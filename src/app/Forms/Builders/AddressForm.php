<?php

namespace LaravelEnso\Addresses\app\Forms\Builders;

use Illuminate\Support\Facades\File;
use LaravelEnso\Addresses\app\Models\Address;
use LaravelEnso\FormBuilder\app\Classes\Form;

class AddressForm
{
    private const TemplatePath = __DIR__.'/../Templates/address.json';

    private $form;

    public function __construct()
    {
        $this->form = (new Form($this->templatePath()));
    }

    public function create()
    {
        return $this->form
            ->title('Create')
            ->actions('store')
            ->create();
    }

    public function edit(Address $address)
    {
        return $this->form
            ->title('Edit')
            ->actions('update')
            ->edit($address);
    }

    private function templatePath()
    {
        $file = config('enso.addresses.formTemplate');

        $templatePath = base_path($file);

        return $file && File::exists($templatePath)
            ? $templatePath
            : self::TemplatePath;
    }
}
