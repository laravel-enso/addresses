<?php

namespace LaravelEnso\Addresses\App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;
use LaravelEnso\Addresses\App\Models\Address;
use LaravelEnso\Helpers\App\Exceptions\EnsoException;

class Coordinates
{
    public static function get(Address $address)
    {
        $apiUrl = Config::get('enso.addresses.googleMaps.url');
        $apiKey = Config::get('enso.addresses.googleMaps.key');

        if (! $apiUrl || ! $apiKey) {
            throw new EnsoException(__('Localisation credentials not set'));
        }

        // \Log::info($association);
        // $url = 'https://maps.googleapis.com/maps/api/geocode/json?address='
        //     .urlencode($address.' '.$city.', '.$state.' '.$zip).'&key='.config('local.maps.key');

        $client = new Client();

        $response = $client->get($apiUrl, [
            'query' => [
                'address' => $address->label(),
                'key' => $apiKey,
            ],
        ]);

        $geocodeData = json_decode($response->getBody());

        $coordinates['lat'] = null;
        $coordinates['lng'] = null;

        if (
            ! empty($geocodeData)
            && $geocodeData->status !== 'ZERO_RESULTS'
            && isset($geocodeData->results, $geocodeData->results[0])

        ) {
            $coordinates['lat'] = $geocodeData->results[0]->geometry->location->lat;
            $coordinates['lng'] = $geocodeData->results[0]->geometry->location->lng;
        }

        return $coordinates;
    }
}
