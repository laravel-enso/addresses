<?php

use LaravelEnso\StructureManager\app\Classes\StructureMigration;

class CreateStructureForAddresses extends StructureMigration
{
    protected $permissionGroup = [
        'name' => 'core.addresses', 'description' => 'Addresses group',
    ];

    protected $permissions = [
        ['name' => 'core.addresses.update', 'description' => 'Update edited address', 'type' => 1, 'is_default' => false],
        ['name' => 'core.addresses.store', 'description' => 'Store newly created address', 'type' => 1, 'is_default' => false],
        ['name' => 'core.addresses.destroy', 'description' => 'Delete address', 'type' => 1, 'is_default' => false],
        ['name' => 'core.addresses.index', 'description' => 'Get addresses for addressable', 'type' => 0, 'is_default' => false],
        ['name' => 'core.addresses.setDefault', 'description' => 'Set Address as is_default', 'type' => 1, 'is_default' => false],
        ['name' => 'core.addresses.edit', 'description' => 'Get Edit Form', 'type' => 0, 'is_default' => false],
        ['name' => 'core.addresses.create', 'description' => 'Get Create Form', 'type' => 0, 'is_default' => false],
        ['name' => 'core.addresses.countriesSelectOptions', 'description' => 'Get countries option list for select', 'type' => 0, 'is_default' => false],
    ];
}
