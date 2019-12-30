<?php

use LaravelEnso\Migrator\App\Database\Migration;
use LaravelEnso\Permissions\App\Enums\Types;

class CreateStructureForAddresses extends Migration
{
    protected $permissions = [
        ['name' => 'core.addresses.update', 'description' => 'Update edited address', 'type' => Types::Write, 'is_default' => false],
        ['name' => 'core.addresses.store', 'description' => 'Store newly created address', 'type' => Types::Write, 'is_default' => false],
        ['name' => 'core.addresses.destroy', 'description' => 'Delete address', 'type' => Types::Write, 'is_default' => false],
        ['name' => 'core.addresses.index', 'description' => 'Get addresses for addressable', 'type' => Types::Read, 'is_default' => false],
        ['name' => 'core.addresses.makeDefault', 'description' => 'Make Address as default', 'type' => Types::Write, 'is_default' => false],
        ['name' => 'core.addresses.edit', 'description' => 'Get Edit Form', 'type' => Types::Read, 'is_default' => false],
        ['name' => 'core.addresses.create', 'description' => 'Get Create Form', 'type' => Types::Read, 'is_default' => false],
    ];
}
