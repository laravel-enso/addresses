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
    'streetTypes' => [
        'Street' => 'Street',
    ],
    'validations' => [
        'update' => [
            'street'     => 'required',
            'number'     => 'required',
            'country_id' => 'required',
        ],
        'create' => [
            'street'     => 'required',
            'number'     => 'required',
            'country_id' => 'required',
        ],
    ],

];
