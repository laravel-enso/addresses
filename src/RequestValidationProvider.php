<?php

namespace LaravelEnso\AddressesManager;

use Illuminate\Support\ServiceProvider;
use LaravelEnso\AddressesManager\app\Contracts\ValidatesAddressRequest;
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
        $this->app->bind(ValidatesAddressRequest::class,
            config('enso.addresses.requestValidator')
                ? config('enso.addresses.requestValidator')
                : ValidateAddressRequest::class
        );
    }

    public function provides()
    {
        return [ValidatesAddressRequest::class];
    }
}
