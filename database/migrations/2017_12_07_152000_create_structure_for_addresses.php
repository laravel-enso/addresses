<?php

use LaravelEnso\Migrator\Database\Migration;

return new class extends Migration
{
    protected array $permissions = [
        ['name' => 'core.addresses.update', 'description' => 'Update edited address', 'is_default' => false],
        ['name' => 'core.addresses.store', 'description' => 'Store newly created address', 'is_default' => false],
        ['name' => 'core.addresses.destroy', 'description' => 'Delete address', 'is_default' => false],
        ['name' => 'core.addresses.index', 'description' => 'Get addresses for addressable', 'is_default' => false],
        ['name' => 'core.addresses.makeDefault', 'description' => 'Make address as default', 'is_default' => false],
        ['name' => 'core.addresses.makeShipping', 'description' => 'Make address as shipping', 'is_default' => false],
        ['name' => 'core.addresses.makeBilling', 'description' => 'Make address as billing', 'is_default' => false],
        ['name' => 'core.addresses.show', 'description' => 'Get address', 'is_default' => false],
        ['name' => 'core.addresses.edit', 'description' => 'Get Edit Form', 'is_default' => false],
        ['name' => 'core.addresses.localize', 'description' => 'Localize address with google maps', 'is_default' => false],
        ['name' => 'core.addresses.coordinates', 'description' => 'Update coordinates for address', 'is_default' => false],
        ['name' => 'core.addresses.create', 'description' => 'Get Create Form', 'is_default' => false],
        ['name' => 'core.addresses.options', 'description' => 'Get addresses for select', 'is_default' => false],
        ['name' => 'core.addresses.localities', 'description' => 'Get localities for the select', 'is_default' => false],
        ['name' => 'core.addresses.regions', 'description' => 'Get regions for the select', 'is_default' => false],
        ['name' => 'core.addresses.postcode', 'description' => 'Get address based on the postcode', 'is_default' => false],
    ];
};
