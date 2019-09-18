<?php

namespace LaravelEnso\Addresses\app\Exceptions;

use LaravelEnso\Helpers\app\Exceptions\EnsoException;

class AddressException extends EnsoException
{
    public static function removeDefault()
    {
        return new static(__(
            'You cannot delete the default address while having secondary addresses'
        ));
    }
}
