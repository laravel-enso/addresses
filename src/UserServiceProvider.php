<?php

namespace LaravelEnso\Addresses;

use Illuminate\Support\ServiceProvider;
use LaravelEnso\Addresses\Dynamics\Relations\User\Addresses;
use LaravelEnso\DynamicMethods\Services\Methods;
use LaravelEnso\Users\Models\User;

class UserServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Methods::bind(User::class, Addresses::class);
    }
}
