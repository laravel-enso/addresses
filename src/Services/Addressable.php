<?php

namespace LaravelEnso\Addresses\Services;

use LaravelEnso\Addresses\DynamicRelations\Addressables\Addresss;
use LaravelEnso\Addresses\DynamicRelations\Addressables\Addressses;
use LaravelEnso\Addresses\DynamicRelations\Addressables\BillingAddresse;
use LaravelEnso\Addresses\DynamicRelations\Addressables\ShippingAddresses;
use LaravelEnso\Addresses\Observers\Observer;
use LaravelEnso\DynamicMethods\Services\Methods;

class Addressable
{
    public static function register(string $model)
    {
        Methods::bind($model, [
            Addresss::class, Addressses::class, BillingAddresse::class,
            ShippingAddresses::class,
        ]);

        $model::observe(Observer::class);
    }
}
