<?php

namespace LaravelEnso\Addresses\Services;

use LaravelEnso\Addresses\Models\Address;

class Coordinates
{
    public function __construct(private Address $address)
    {
    }

    public function get(): array
    {
        $location = $this->location();

        return [
            'lat' => round($location['lat'], 6),
            'long' => round($location['lng'], 6),
        ];
    }

    private function location(): array
    {
        $response = (new Geocoding([
            'address' => $this->address->label(),
        ]))->handle();

        return $response['geometry']['location'];
    }
}
