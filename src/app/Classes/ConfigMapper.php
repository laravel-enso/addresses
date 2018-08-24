<?php

namespace LaravelEnso\AddressesManager\app\Classes;

use LaravelEnso\Helpers\app\Classes\MorphableConfigMapper;

class ConfigMapper extends MorphableConfigMapper
{
    protected $configPrefix = 'enso.addresses';
    protected $morphableKey = 'addressables';
}
