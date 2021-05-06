<?php

namespace LaravelEnso\Addresses;

use Illuminate\Support\ServiceProvider;
use LaravelEnso\Addresses\Dynamics\Relations\User\Addresses;
use LaravelEnso\Core\Models\User;
use LaravelEnso\DynamicMethods\Services\Methods;

class UserServiceProvider extends ServiceProvider
{
    public $methods = [
        Addresses::class,
    ];

    public function boot()
    {
        Methods::bind(User::class, $this->methods);
    }
}
