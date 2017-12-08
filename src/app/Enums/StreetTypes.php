<?php
/**
 * Created by PhpStorm.
 * User: mihai
 * Date: 12/5/17
 * Time: 12:38 PM.
 */

namespace LaravelEnso\AddressesManager\app\Enums;

use LaravelEnso\Helpers\Classes\AbstractEnum;

class StreetTypes extends AbstractEnum
{
    public $data = [];

    public function __construct()
    {
        $types = collect(config('addresses.streetTypes'));

        $this->data = $types->map(function ($k, $v) {
            return __($v);
        });
    }
}
