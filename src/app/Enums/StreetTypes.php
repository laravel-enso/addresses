<?php

namespace LaravelEnso\Addresses\App\Enums;

use LaravelEnso\Enums\App\Services\Enum;

class StreetTypes extends Enum
{
    protected static function attributes()
    {
        return config('enso.addresses.streetTypes');
    }
}
