<?php

use LaravelEnso\Migrator\app\Database\Migration;

class CreateStructureForAddresses extends Migration
{
    protected $permissions = [
        ['name' => 'core.addresses.update', 'description' => 'Update edited address', 'type' => 1, 'is_default' => false],
        ['name' => 'core.addresses.store', 'description' => 'Store newly created address', 'type' => 1, 'is_default' => false],
        ['name' => 'core.addresses.destroy', 'description' => 'Delete address', 'type' => 1, 'is_default' => false],
        ['name' => 'core.addresses.index', 'description' => 'Get addresses for addressable', 'type' => 0, 'is_default' => false],
        ['name' => 'core.addresses.makeDefault', 'description' => 'Make Address as default', 'type' => 1, 'is_default' => false],
        ['name' => 'core.addresses.edit', 'description' => 'Get Edit Form', 'type' => 0, 'is_default' => false],
        ['name' => 'core.addresses.create', 'description' => 'Get Create Form', 'type' => 0, 'is_default' => false],
    ];
}
