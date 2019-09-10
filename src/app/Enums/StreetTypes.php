<?php

namespace LaravelEnso\Addresses\app\Enums;

use LaravelEnso\Enums\app\Services\Enum;

class StreetTypes extends Enum
{
    protected static function attributes()
    {
        return config('enso.addresses.streetTypes');
    }
}
