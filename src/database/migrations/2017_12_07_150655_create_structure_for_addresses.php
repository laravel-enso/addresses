<?php

use LaravelEnso\StructureManager\app\Classes\StructureMigration;

class CreateStructureForAddresses extends StructureMigration
{
    protected $permissions = [
        ['name' => 'core.addresses.update', 'description' => 'Update edited address', 'type' => 1, 'is_default' => false],
        ['name' => 'core.addresses.store', 'description' => 'Store newly created address', 'type' => 1, 'is_default' => false],
        ['name' => 'core.addresses.destroy', 'description' => 'Delete address', 'type' => 1, 'is_default' => false],
        ['name' => 'core.addresses.index', 'description' => 'Get addresses for addressable', 'type' => 0, 'is_default' => false],
        ['name' => 'core.addresses.setDefault', 'description' => 'Set Address as is_default', 'type' => 1, 'is_default' => false],
        ['name' => 'core.addresses.edit', 'description' => 'Get Edit Form', 'type' => 0, 'is_default' => false],
        ['name' => 'core.addresses.create', 'description' => 'Get Create Form', 'type' => 0, 'is_default' => false],
        ['name' => 'core.addresses.countryOptions', 'description' => 'Get country options for select', 'type' => 0, 'is_default' => false],
    ];
}
