<?php

namespace LaravelEnso\Addresses\App\Traits;

use LaravelEnso\Addresses\App\Models\Address;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

trait Addressable
{
    public static function bootAddressable()
    {
        self::deleting(function ($model) {
            if (config('enso.addresses.onDelete') === 'restrict'
                && $model->addresses()->first() !== null) {
                throw new ConflictHttpException(
                    __('The entity has addresses and cannot be deleted')
                );
            }
        });

        self::deleted(function ($model) {
            if (config('enso.addresses.onDelete') === 'cascade') {
                $model->addresses()->delete();
            }
        });
    }

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function defaultAddress()
    {
        return $this->addresses()
            ->default()
            ->first();
    }
}
