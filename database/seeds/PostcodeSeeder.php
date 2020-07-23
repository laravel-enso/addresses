<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use LaravelEnso\Addresses\Models\Region;
use LaravelEnso\Addresses\Models\Postcode;
use LaravelEnso\Countries\Models\Country;
use LaravelEnso\Helpers\Services\JsonReader;

class PostcodeSeeder extends Seeder
{
    private const Postcodes = __DIR__.'/../../vendor/laravel-enso/addresses/database/postcodes.json';

    public function run()
    {
        DB::beginTransaction();

        $us = Country::whereName('United States')->first();
        $regions = Region::whereCountryId($us->id)->get()
            ->mapWithKeys(fn ($region) => [$region->abbreviation => $region->id]);

        if ($us) {
            $this->postcodes()
                ->map(fn ($postcode) => [
                    'city' => $postcode['city'],
                    'long' => $postcode['long'],
                    'lat' => $postcode['lat'],
                    'code' => $postcode['zip'],
                    'country_id' => $us->id,
                    'region_id' => $regions[$postcode['state_id']],
                ])->chunk(250)
                ->each(fn ($postcodes) => Postcode::insert($postcodes->toArray()));
        }

        DB::commit();
    }

    public function postcodes()
    {
        return (new JsonReader(self::Postcodes))->collection();
    }
}
