<?php

namespace LaravelEnso\Addresses\app\Enums;

use LaravelEnso\Enums\app\Services\Enum;

class BuildingTypes extends Enum
{
    protected static function attributes()
    {
        return config('enso.addresses.buildingTypes');
    }
}
