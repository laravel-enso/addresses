<?php

namespace LaravelEnso\AddressesManager;

use Illuminate\Database\Console\Migrations\MigrateCommand;
use Illuminate\Support\ServiceProvider;
use LaravelEnso\AddressesManager\App\Console;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishesAll();
        $this->loadDependencies();
        $this->loadCommands();
    }

    private function publishesAll()
    {
        $this->publishes([
            __DIR__.'/config' => config_path('enso'),
        ], 'addresses-config');

        $this->publishes([
            __DIR__.'/app/Forms/Templates' => app_path().'/Forms/vendor/',
        ], 'addresses-form');

        $this->publishes([
            __DIR__.'/config' => config_path('enso'),
        ], 'enso-config');

        $this->publishes([
            __DIR__.'/resources/assets/js' => resource_path('assets/js'),
        ], 'addresses-assets');

        $this->publishes([
            __DIR__.'/resources/assets/js' => resource_path('assets/js'),
        ], 'enso-assets');
    }

    private function loadDependencies()
    {
        $this->mergeConfigFrom(__DIR__.'/config/addresses.php', 'enso.addresses');
        $this->loadRoutesFrom(__DIR__.'/routes/api.php');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'laravel-enso/addressesmanager');
    }

    private function loadCommands()
    {
        $this->commands([
            Console\MigrateCommand::class
        ]);
    }

    public function register()
    {
        //
    }
}
