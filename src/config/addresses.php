<?php
/**
 * Created by PhpStorm.
 * User: mihai
 * Date: 12/5/17
 * Time: 12:22 PM.
 */

return [

    'addressables' => [
        'owner' => \App\Owner::class,
        'user'  => \App\User::class,
    ],
    'streetTypes'  => [
        'Street' => 'Street',
        'Avenue' => 'Avenue',
        'Boulevard' => 'Boulevard',
        'Parade' => 'Parade',
        'Road' => 'Road',
        'Lane' => 'Lane',
        'Route' => 'Route',
        'Row' => 'Row',
        'Vista' => 'Vista',
        'Bend' => 'Bend',
        'Square' => 'Square',
    ],
    'validations'  => [
        'street'     => 'required',
        'city'       => 'required',
        'country_id' => 'required',
    ],
];
