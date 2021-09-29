<?php

namespace LaravelEnso\Addresses\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use LaravelEnso\Addresses\Exceptions\Localize;
use LaravelEnso\Addresses\Models\Address;
use LaravelEnso\Google\Models\Settings;

class Geocoding
{
    public function __construct(private array $payload)
    {
    }

    public function get(): array
    {
        return $this->geocodeData();
    }

    private function geocodeData(): array
    {
        $geocodeData = $this->apiCall();

        if ($geocodeData['status'] === 'REQUEST_DENIED') {
            throw Localize::wrongApiKey();
        }

        if ($this->failed($geocodeData)) {
            throw Localize::failed();
        }

        return $geocodeData['results'][0];
    }

    private function failed($geocodeData): bool
    {
        return empty($geocodeData)
            || $geocodeData['status'] === 'ZERO_RESULTS'
            || !isset($geocodeData['results'][0]);
    }

    private function apiCall(): array
    {
        $response = Http::get($this->apiUrl(), $this->payload + [
            'key' => $this->apiKey(),
        ]);

        if ($response->failed()) {
            throw Localize::wrongApiUrl();
        }

        return $response->json();
    }

    private function apiUrl(): string
    {
        $url = Settings::mapsURL();

        if (!$url) {
            throw Localize::missingApiUrl();
        }

        return $url;
    }

    private function apiKey(): string
    {
        $key = Settings::mapsKey();

        if (!$key) {
            throw Localize::missingApiKey();
        }

        return $key;
    }
}
