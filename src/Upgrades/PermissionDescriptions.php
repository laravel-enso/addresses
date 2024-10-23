<?php

namespace LaravelEnso\Addresses\Upgrades;

use LaravelEnso\Permissions\Models\Permission;
use LaravelEnso\Upgrade\Contracts\MigratesData;
use LaravelEnso\Upgrade\Traits\StructureMigration;

class PermissionDescriptions implements MigratesData
{
    use StructureMigration;

    public function isMigrated(): bool
    {
        return Permission::whereName('core.addresses.localities')
            ->whereDescription('Get localities for the select')
            ->doesntExist();
    }

    public function migrateData(): void
    {
        Permission::whereName('core.addresses.localities')
            ->update(['description' => 'Get localities options for select']);
        Permission::whereName('core.addresses.regions')
            ->update(['description' => 'Get region options for select']);
    }
}
