<?php

return [
    'onDelete'         => 'cascade',
    'defaultCountryId' => (int) env('DEFAULT_CONTRY_ID', 1),
];
