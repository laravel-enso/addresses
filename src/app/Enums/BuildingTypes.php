<?php

namespace LaravelEnso\AddressesManager\app\Enums;

use LaravelEnso\Helpers\app\Classes\Enum;

class BuildingTypes extends Enum
{
    protected static function attributes()
    {
        return config('enso.addresses.buildingTypes');
    }
}
