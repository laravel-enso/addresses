<?php

namespace LaravelEnso\Addresses\App\Exceptions;

use LaravelEnso\Helpers\App\Exceptions\EnsoException;

class Address extends EnsoException
{
    public static function cannotRemoveDefault()
    {
        return new static(__(
            'You cannot delete the default address while having secondary addresses'
        ));
    }
}
