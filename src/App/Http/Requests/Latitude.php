<?php

namespace LaravelEnso\Addresses\App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;

class Latitude implements Rule
{
    protected const Pattern = "/^(\+|-)?(?:90(?:(?:\.0{1,6})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{1,6})?))$/";

    public function passes($attribute, $value)
    {
        return preg_match(self::Pattern, $value);
    }

    public function message()
    {
        return __('The :attribute must be a valid coordinate');
    }
}
