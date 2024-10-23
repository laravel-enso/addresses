<?php

namespace LaravelEnso\Addresses\Upgrades;

use LaravelEnso\Upgrade\Contracts\MigratesStructure;
use LaravelEnso\Upgrade\Traits\StructureMigration;

class SectorPermission implements MigratesStructure
{
    use StructureMigration;

    protected array $permissions = [
        ['name' => 'core.addresses.sectors', 'description' => 'Get sector options for select', 'is_default' => false],
    ];

    protected array $roles = ['admin', 'supervisor'];
}
