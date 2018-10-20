<?php

namespace LaravelEnso\AddressesManager;

use Illuminate\Support\ServiceProvider;
use LaravelEnso\AddressesManager\App\Http\Requests\ValidateAddressRequest;

class RequestValidationProvider extends ServiceProvider
{
    protected $defer = true;

    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->bind(ValidateAddressRequest::class, function () {
            return config('enso.addresses.requestValidator')
                ? $this->app->make(config('enso.addresses.requestValidator'))
                : new ValidateAddressRequest();
        });
    }

    public function provides()
    {
        return [ValidateAddressRequest::class];
    }
}
