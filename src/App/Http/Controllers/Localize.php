<?php

namespace LaravelEnso\Addresses\App\Http\Controllers;

use LaravelEnso\Addresses\App\Services\Coordinates;
use Illuminate\Routing\Controller;
use LaravelEnso\Addresses\App\Models\Address;

class Localize extends Controller
{
    public function __invoke(Address $address)
    {
        $coordinates = Coordinates::get($address);

        if ($coordinates['lat'] && $coordinates['lng']) {
            $address->update([
                'lat' => $coordinates['lat'],
                'long' => $coordinates['lng']
            ]);
        }

        return $coordinates;
    }
}
