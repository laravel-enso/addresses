<?php

use LaravelEnso\Migrator\App\Database\Migration;

class CreateStructureForAddresses extends Migration
{
    protected $permissions = [
        ['name' => 'core.addresses.update', 'description' => 'Update edited address', 'is_default' => false],
        ['name' => 'core.addresses.store', 'description' => 'Store newly created address', 'is_default' => false],
        ['name' => 'core.addresses.destroy', 'description' => 'Delete address', 'is_default' => false],
        ['name' => 'core.addresses.index', 'description' => 'Get addresses for addressable', 'is_default' => false],
        ['name' => 'core.addresses.makeDefault', 'description' => 'Make Address as default', 'is_default' => false],
        ['name' => 'core.addresses.edit', 'description' => 'Get Edit Form', 'is_default' => false],
        ['name' => 'core.addresses.create', 'description' => 'Get Create Form', 'is_default' => false],
    ];
}
