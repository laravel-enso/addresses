<?php

namespace LaravelEnso\Addresses\Services;

use Illuminate\Support\Facades\Http;
use LaravelEnso\Addresses\Exceptions\Localize;
use LaravelEnso\Addresses\Models\Address;
use LaravelEnso\Google\Models\Settings;

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
            "address" => $this->address->label()
        ]))->get();

        return $geocodeData['geometry']['location'];
    }
}
