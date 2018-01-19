<?php

namespace LaravelEnso\AddressesManager\app\Handlers;

use LaravelEnso\AddressesManager\app\Exceptions\AddressConfigException;

class ConfigMapper
{
    protected $commentable;
    private $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function class()
    {
        $addressable = config('enso.addresses.addressables.'.$this->type);

        if (!$addressable) {
            throw new AddressConfigException(__(
                'Entity :entity does not exist in enso/addresses.php config file',
                ['entity' => $this->type]
            ));
        }

        return $addressable;
    }
}
