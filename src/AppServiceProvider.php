<?php

namespace LaravelEnso\AddressesManager;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishesAll();
        $this->loadDependencies();
    }

    private function publishesAll()
    {
        $this->publishes([
            __DIR__.'/config' => config_path('enso'),
        ], 'addresses-config');

        $this->publishes([
            __DIR__.'/app/Forms' => app_path().'/Forms/vendor/',
        ], 'addresses-form');

        $this->publishes([
            __DIR__.'/config' => config_path('enso'),
        ], 'enso-config');
    }

    private function loadDependencies()
    {
        $this->mergeConfigFrom(__DIR__.'/config/addresses.php', 'enso.addresses');
        $this->loadRoutesFrom(__DIR__.'/routes/api.php');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'laravel-enso/addressesmanager');
    }

    public function register()
    {
        //
    }
}
