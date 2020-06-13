<?php

namespace LaravelEnso\Addresses\App\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use LaravelEnso\Addresses\App\Exceptions\Localize;
use LaravelEnso\Addresses\App\Models\Address;

class Coordinates
{
    private Address $address;

    public function __construct(Address $address)
    {
        $this->address = $address;
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
        $geocodeData = $this->apiCall();

        if ($geocodeData['status'] === 'REQUEST_DENIED') {
            throw Localize::wrongApiKey();
        }

        if (empty($geocodeData) || $geocodeData['status'] === 'ZERO_RESULTS'
            || ! isset($geocodeData['results'], $geocodeData['results'][0])) {
            throw Localize::failed();
        }

        return $geocodeData['results'][0]['geometry']['location'];
    }

    private function apiCall(): array
    {
        $response = Http::get($this->apiUrl(), [
            'address' => $this->address->label(),
            'key' => $this->apiKey(),
        ]);

        if ($response->failed()) {
            throw Localize::wrongApiUrl();
        }

        return $response->json();
    }

    private function apiUrl(): string
    {
        $url = Config::get('enso.addresses.googleMaps.url');

        if (! $url) {
            throw Localize::missingApiUrl();
        }

        return $url;
    }

    private function apiKey(): string
    {
        $key = Config::get('enso.addresses.googleMaps.key');

        if (! $key) {
            throw Localize::missingApiKey();
        }

        return $key;
    }
}
