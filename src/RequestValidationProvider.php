<?php

namespace LaravelEnso\AddressesManager;

use Illuminate\Support\ServiceProvider;
use LaravelEnso\AddressesManager\app\Contracts\ValidatesAddressRequest;
use LaravelEnso\AddressesManager\App\Http\Requests\ValidateAddressRequest;

class RequestValidationProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->bind(
            ValidatesAddressRequest::class,
            ValidateAddressRequest::class
        );
    }
}
