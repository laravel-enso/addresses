<?php

use LaravelEnso\StructureManager\app\Classes\StructureMigration;

class CreateStructureForAddresses extends StructureMigration
{
    protected $permissionGroup = [
        'name' => 'addresses', 'description' => 'Addresses group',
    ];

    protected $permissions = [
        ['name' => 'addresses.update', 'description' => 'Update edited address', 'type' => 1, 'default' => false],
        ['name' => 'addresses.store', 'description' => 'Store newly created address', 'type' => 1, 'default' => false],
        ['name' => 'addresses.destroy', 'description' => 'Delete address', 'type' => 1, 'default' => false],
        ['name' => 'addresses.list', 'description' => 'Get addresses for addressable', 'type' => 0, 'default' => false],
        ['name' => 'addresses.setDefault', 'description' => 'Set Address as default', 'type' => 1, 'default' => false],
        ['name' => 'addresses.getEditForm', 'description' => 'Get Edit Form', 'type' => 0, 'default' => false],
        ['name' => 'addresses.getCreateForm', 'description' => 'Get Create Form', 'type' => 0, 'default' => false],
    ];
}
