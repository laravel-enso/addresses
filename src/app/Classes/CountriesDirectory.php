<?php

namespace LaravelEnso\AddressesManager\app\Classes;



use Illuminate\Support\Facades\Log;

class CountriesDirectory
{

    public $data;

    public function __construct()
    {

        $filePath = __DIR__.'/../../database/countries.json';
        $this->data = json_decode(\File::get($filePath), TRUE);
    }

    public function all()
    {
        return $this->data;
    }

}