<?php

namespace LaravelEnso\Addresses\app\Exceptions;

use LaravelEnso\Helpers\app\Exceptions\EnsoException;

class Address extends EnsoException
{
    public static function cannotRemoveDefault()
    {
        return new static(__(
            'You cannot delete the default address while having secondary addresses'
        ));
    }
}
