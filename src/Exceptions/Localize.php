<?php

namespace LaravelEnso\Addresses\Exceptions;

use LaravelEnso\Helpers\Exceptions\EnsoException;

class Localize extends EnsoException
{
    public static function missingApiUrl()
    {
        return new static(__('Google maps api url is missing'));
    }

    public static function wrongApiUrl()
    {
        return new static(__('Google maps api url is incorrect'));
    }

    public static function missingApiKey()
    {
        return new static(__('Google maps api key is missing'));
    }

    public static function wrongApiKey()
    {
        return new static(__('Google maps api key is incorrect'));
    }

    public static function failed()
    {
        return new static(__('Unable to localize this address'));
    }
}
