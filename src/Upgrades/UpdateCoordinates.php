<?php

namespace LaravelEnso\Addresses\Upgrades;

use LaravelEnso\Upgrade\Contracts\MigratesStructure;

class UpdateCoordinates implements MigratesStructure
{
    public function permissions(): array
    {
        return [
            ['name' => 'core.addresses.coordinates', 'description' => 'Update coordinates for address', 'is_default' => false],
        ];
    }

    public function roles(): array
    {
        return ['admin', 'supervisor'];
    }
}
