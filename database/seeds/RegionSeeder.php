<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use LaravelEnso\Addresses\Models\Region;
use LaravelEnso\Countries\Models\Country;
use LaravelEnso\Helpers\Services\JsonReader;

class RegionSeeder extends Seeder
{
    private const Regions = __DIR__.'/../../vendor/laravel-enso/addresses/database/regions';

    public function run()
    {
        DB::transaction(fn () => $this->countries()
            ->each(fn (Country $country) => $this->importRegions($country)));
    }

    private function importRegions(Country $country)
    {
        $this->regions($country)
            ->map(fn ($region) => (new Collection($region))
                ->mapWithKeys(fn ($value, $key) => [Str::snake($key) => $value])
                ->put('country_id', $country->id)
                ->toArray())
            ->chunk(250)
            ->each(fn ($regions) => Region::insert($regions->toArray()));
    }

    private function regions(Country $country): Collection
    {
        $fileName = self::Regions.DIRECTORY_SEPARATOR."{$country->iso_3166_3}.json";

        return (new JsonReader($fileName))
            ->collection()
            ->unique(fn ($region) => $region['abbreviation']);
    }

    private function countries(): Collection
    {
        return (new Collection(File::files(self::Regions)))
            ->map(fn (SplFileInfo $file) => Country::where('iso_3166_3', $file->getBasename('.json'))->first())
            ->filter();
    }
}
