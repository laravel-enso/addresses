<?php

namespace LaravelEnso\Addresses\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use LaravelEnso\Addresses\Models\Township;
use LaravelEnso\Countries\Models\Country;
use LaravelEnso\Helpers\Services\JsonReader;

class TownshipSeeder extends Seeder
{
    public function run()
    {
        DB::transaction(fn () => $this->countries()
            ->each(fn (Country $country) => $this->importTownships($country)));
    }

    private function importTownships(Country $country)
    {
        $this->townships($country)
            ->map(fn ($township) => (new Collection($township))
                ->mapWithKeys(fn ($value, $key) => [Str::snake($key) => $value])
                ->put('created_at', Carbon::now())
                ->put('updated_at', Carbon::now())
                ->toArray())
            ->chunk(250)
            ->each(fn ($townships) => Township::insert($townships->toArray()));
    }

    private function townships(Country $country): Collection
    {
        return (new JsonReader($this->path(["{$country->iso_3166_3}.json"])))
            ->collection()
            ->unique(fn ($township) => $township['id']);
    }

    private function countries(): Collection
    {
        return (new Collection(File::files($this->path())))
            ->map(fn (SplFileInfo $file) => Country::where('iso_3166_3', $file->getBasename('.json'))->first())
            ->filter();
    }

    private function path(array $path = []): string
    {
        return (new Collection([
            base_path('vendor/laravel-enso/addresses/database/townships'),
            ...$path,
        ]))->implode(DIRECTORY_SEPARATOR);
    }
}
