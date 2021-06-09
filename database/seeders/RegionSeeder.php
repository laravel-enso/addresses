<?php

namespace LaravelEnso\Addresses\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use LaravelEnso\Addresses\Models\Region;
use LaravelEnso\Countries\Models\Country;
use LaravelEnso\Helpers\Services\JsonReader;
use Symfony\Component\Finder\SplFileInfo;

class RegionSeeder extends Seeder
{
    public function run()
    {
        $this->countries()
            ->each(fn (Country $country) => $this->importRegions($country));
    }

    private function importRegions(Country $country)
    {
        $this->regions($country)
            ->map(fn ($region) => Collection::wrap($region)
                ->mapWithKeys(fn ($value, $key) => [Str::snake($key) => $value])
                ->put('country_id', $country->id)
                ->put('created_at', Carbon::now())
                ->put('updated_at', Carbon::now())
                ->toArray())
            ->chunk(250)
            ->each(fn ($regions) => Region::insert($regions->toArray()));
    }

    private function regions(Country $country): Collection
    {
        return (new JsonReader($this->path(["{$country->iso_3166_3}.json"])))
            ->collection()
            ->unique(fn ($region) => $region['abbreviation']);
    }

    private function countries(): Collection
    {
        return Collection::wrap(File::files($this->path()))
            ->map(fn (SplFileInfo $file) => Country::where('iso_3166_3', $file->getBasename('.json'))->first())
            ->filter();
    }

    private function path(array $path = []): string
    {
        return Collection::wrap([
            base_path('vendor/laravel-enso/addresses/database/regions'), ...$path,
        ])->implode(DIRECTORY_SEPARATOR);
    }
}
