<?php

return [
    'addressables' => [
        'owner' => App\Owner::class,
    ],
    'streetTypes' => [
        'Street'    => 'Street',
        'Avenue'    => 'Avenue',
        'Boulevard' => 'Boulevard',
        'Parade'    => 'Parade',
        'Road'      => 'Road',
        'Lane'      => 'Lane',
        'Route'     => 'Route',
        'Row'       => 'Row',
        'Vista'     => 'Vista',
        'Bend'      => 'Bend',
        'Square'    => 'Square',
    ],
    'buildingTypes' => [
        'House'   => 'House',
        'Bloc'    => 'Bloc',
        'Offices' => 'Offices',
    ],
    'validations' => [
        'street'     => 'required',
        'city'       => 'required',
        'country_id' => 'required',
    ],
];
