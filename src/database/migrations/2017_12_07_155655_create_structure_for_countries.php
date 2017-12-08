<?php

use LaravelEnso\StructureManager\app\Classes\StructureMigration;

class CreateStructureForCountries extends StructureMigration
{
    protected $permissionGroup = [
        'name' => 'countries', 'description' => 'Countries group',
    ];

    protected $permissions = [

        ['name' => 'countries.getOptionList', 'description' => 'Get countries for the select', 'type' => 0, 'default' => false],

    ];
}
