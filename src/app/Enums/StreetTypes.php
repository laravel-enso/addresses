<?php

namespace LaravelEnso\Addresses\app\Enums;

use LaravelEnso\Helpers\app\Classes\Enum;

class StreetTypes extends Enum
{
    protected static function attributes()
    {
        return config('enso.addresses.streetTypes');
    }
}
