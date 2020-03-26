<?php

namespace LaravelEnso\Addresses\App\Enums;

use LaravelEnso\Enums\App\Services\Enum;

class BuildingTypes extends Enum
{
    protected static function data(): array
    {
        return config('enso.addresses.buildingTypes');
    }
}
