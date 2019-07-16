<?php

namespace LaravelEnso\Addresses;

use Illuminate\Support\ServiceProvider;
use LaravelEnso\Addresses\app\Models\Address;
use LaravelEnso\Addresses\app\Observers\Observer;

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
            __DIR__.'/database/factories' => database_path('factories'),
        ], 'addresses-factory');

        $this->publishes([
            __DIR__.'/database/factories' => database_path('factories'),
        ], 'enso-factories');

        $this->publishes([
            __DIR__.'/config' => config_path('enso'),
        ], 'addresses-config');

        $this->publishes([
            __DIR__.'/config' => config_path('enso'),
        ], 'enso-config');
    }
}
