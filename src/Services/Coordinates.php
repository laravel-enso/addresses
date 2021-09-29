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
        $geocodeData = (new Geocoding([
            'address' => $this->address->label(),
        ]))->get();

        return $geocodeData['geometry']['location'];
    }
}
