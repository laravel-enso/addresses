<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use LaravelEnso\StructureManager\app\Classes\StructureMigration;

class CreateStructureForAddresses extends StructureMigration
{
    protected $permissionGroup = [
        'name' => 'addresses', 'description' => 'Addresses group',
    ];

    protected $permissions = [
        ['name' => 'addresses.index', 'description' => 'Show addresses index', 'type' => 0, 'default' => false],
        ['name' => 'addresses.update', 'description' => 'Update edited address', 'type' => 1, 'default' => false],
        ['name' => 'addresses.store', 'description' => 'Store newly created address', 'type' => 1, 'default' => false],
        ['name' => 'addresses.destroy', 'description' => 'Delete address', 'type' => 1, 'default' => false],
        ['name' => 'addresses.list', 'description' => 'Get addresses for addressable', 'type' => 0, 'default' => false],
        ['name' => 'addresses.initTable', 'description' => 'Init table for addresses', 'type' => 0, 'default' => false],
        ['name' => 'addresses.getTableData', 'description' => 'Get table data for addresses', 'type' => 0, 'default' => false],
        ['name' => 'addresses.exportExcel', 'description' => 'Export excel for addresses', 'type' => 0, 'default' => false],
        ['name' => 'addresses.getEditForm', 'description' => 'Get Edit Form', 'type' => 0, 'default' => false],
        ['name' => 'addresses.getCreateForm', 'description' => 'Get Create Form', 'type' => 0, 'default' => false],
    ];

    protected $menu = [
        'name' => 'Addresses', 'icon' => 'fa fa-fw fa-location-arrow', 'link' => 'addresses', 'has_children' => false,
    ];

    protected $parentMenu = 'Administration';
}
