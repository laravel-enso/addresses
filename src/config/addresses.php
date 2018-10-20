<?php


return [
    'onDelete' => 'cascade',
    'requestValidator' => null,
    'formTemplate' => null,
    'loggableMorph' => [
        'addressable' => [],
    ],
    'streetTypes' => [
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
    'buildingTypes' => [
        'Offices' => 'Offices',
        'Residential' => 'Residential',
        'Comercial' => 'Comercial',
        'Industrial' => 'Industrial',
    ],
];
