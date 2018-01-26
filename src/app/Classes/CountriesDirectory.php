<?php

namespace LaravelEnso\AddressesManager\app\Classes;

class CountriesDirectory
{
    public $data;

    public function __construct()
    {
        $filePath = __DIR__.'/../../database/countries.json';
        $this->data = json_decode(\File::get($filePath), true);
    }

    public function all()
    {
        return $this->data;
    }

    public function collection()
    {
        return collect($this->data);
    }
}
