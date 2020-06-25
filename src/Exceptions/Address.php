<?php

namespace LaravelEnso\Addresses\Exceptions;

use LaravelEnso\Helpers\Exceptions\EnsoException;

class Address extends EnsoException
{
    public static function cannotRemoveDefault()
    {
        return new static(__(
            'You cannot delete the default address while having a secondary one'
        ));
    }

    public static function cannotHaveMultiple()
    {
        return new static(__(
            'You cannot add multiple addresses to this entity'
        ));
    }
}
