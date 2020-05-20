<?php

return [
    'onDelete' => 'cascade',
    'loggableMorph' => [
        'addressable' => [],
    ],
    'label' => [
        'separator' => ' - ',
        'attributes' => [
            'locality', 'street',
        ],
    ],
    'defaultCountryId' => 184,
];
