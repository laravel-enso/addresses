<?php

namespace LaravelEnso\Addresses\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use LaravelEnso\Addresses\Exceptions\Localize;
use LaravelEnso\Google\Models\Settings;

class Geocoding
{
    public function __construct(private array $payload)
    {
    }

    public function components(): self
    {
        $this->payload = Collection::wrap($this->payload)
            ->map(fn ($value, $key) => $key . ':' . $value)
            ->implode('|');

        return $this;
    }

    public function handle(): array
    {
        $response = $this->apiCall();

        if ($response['status'] === 'REQUEST_DENIED') {
            throw Localize::wrongApiKey();
        }

        if ($this->failed($response)) {
            throw Localize::failed($response['error_message']);
        }

        if ($this->noResults($response)) {
            throw Localize::noResults();
        }

        return $response['results'][0];
    }

    private function failed($response): bool
    {
        return $response['status'] === 'REQUEST_DENIED'
            || $response['status'] === 'INVALID_REQUEST';
    }

    private function noResults($response): bool
    {
        return empty($response)
            || $response['status'] === 'ZERO_RESULTS';
    }

    private function apiCall(): array
    {
        $response = Http::get($this->apiUrl(), $this->payload + [
            'key' => $this->apiKey(),
        ]);

        if ($response->failed()) {
            throw Localize::failed($response['error_message'] ?? null);
        }

        return $response->json();
    }

    private function apiUrl(): string
    {
        $url = Settings::mapsURL();

        if (! $url) {
            throw Localize::missingApiUrl();
        }

        return $url;
    }

    private function apiKey(): string
    {
        $key = Settings::mapsKey();

        if (! $key) {
            throw Localize::missingApiKey();
        }

        return $key;
    }
}
