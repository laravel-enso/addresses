<?php

namespace LaravelEnso\Addresses\Traits;

use Illuminate\Support\Facades\Config;
use LaravelEnso\Addresses\Models\Address;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

trait Addressable
{
    public static function bootAddressable()
    {
        self::deleting(function ($model) {
            $shouldRestrict = Config::get('enso.addresses.onDelete') === 'restrict'
                && $model->addresses()->exists();

            if ($shouldRestrict) {
                throw new ConflictHttpException(
                    __('The entity has addresses and cannot be deleted')
                );
            }
        });

        self::deleted(function ($model) {
            if (Config::get('enso.addresses.onDelete') === 'cascade') {
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
        return $this->morphMany(Address::class, 'addressable')
            ->whereIsDefault(true);
    }
}
