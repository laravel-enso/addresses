<?php

namespace LaravelEnso\AddressesManager;

use Illuminate\Support\ServiceProvider;
use LaravelEnso\AddressesManager\app\Models\Address;
use LaravelEnso\AddressesManager\app\Observers\Observer;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Address::observe(Observer::class);

        $this->loadDependencies()
            ->publishDependencies();
    }

    private function loadDependencies()
    {
        $this->mergeConfigFrom(__DIR__.'/config/addresses.php', 'enso.addresses');
        $this->loadRoutesFrom(__DIR__.'/routes/api.php');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        return $this;
    }

    private function publishDependencies()
    {
        $this->publishes([
            __DIR__.'/database/seeds' => database_path('seeds'),
        ], 'addresses-seeder');

        $this->publishes([
            __DIR__.'/database/seeds' => database_path('seeds'),
        ], 'enso-seeders');

        $this->publishes([
            __DIR__.'/config' => config_path('enso'),
        ], 'addresses-config');

        $this->publishes([
            __DIR__.'/config' => config_path('enso'),
        ], 'enso-config');
    }

    public function register()
    {
        //
    }
}
