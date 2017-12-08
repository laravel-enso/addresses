<?php

namespace LaravelEnso\AddressesManager;

use Illuminate\Support\ServiceProvider;

class AddressesManagerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishesAll();
        $this->loadDependencies();
    }

    private function publishesAll()
    {
        $this->publishes([
            __DIR__.'/config' => config_path(),
        ], 'addresses-config');

        $this->publishes([
            __DIR__.'/app/Forms' => app_path().'/Forms/vendor/',
        ], 'addresses-form');

        $this->publishes([
            __DIR__.'/config' => config_path(),
        ], 'enso-config');
    }

    private function loadDependencies()
    {
        $this->mergeConfigFrom(__DIR__.'/config/addresses.php', 'addresses');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'laravel-enso/addressesmanager');
    }

    public function register()
    {
        //
    }
}
