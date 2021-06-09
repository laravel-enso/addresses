<?php

return [
    'onDelete' => 'cascade',
    'defaultCountryId' => (int) env('DEFAULT_CONTRY_ID', 1),
    'googleMaps' => [
        'key' => env('GOOGLE_MAPS_KEY'),
        'url' => 'https://maps.googleapis.com/maps/api/geocode/json',
    ],
];
