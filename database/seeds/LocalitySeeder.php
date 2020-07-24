<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use LaravelEnso\Countries\Models\Country;
use LaravelEnso\Helpers\Services\JsonReader;

class LocalitySeeder extends Seeder
{
    const Localities = __DIR__.'/../../vendor/laravel-enso/addresses/database/cities';

    public function run()
    {
        $this->countries()->each(fn (Country $country) => $this->counties($country)
            ->each(fn ($county) => DB::table('localities')
                ->insert($this->localities($country, $county))))
        ;
    }

    private function counties(Country $country): Collection
    {
        return (new Collection(File::files(self::Localities.DIRECTORY_SEPARATOR.$country->iso_3166_3)))
            ->when(App::runningUnitTests(), fn ($counties) => $counties->slice(0, 1));
    }

    private function localities(Country $country, $county): array
    {
        $fileName = self::Localities.DIRECTORY_SEPARATOR.$country->iso_3166_3.DIRECTORY_SEPARATOR.$county->getFileName();

        return (new JsonReader($fileName))->collection()
            ->map(fn ($locality) => (new Collection($locality))
                ->mapWithKeys(fn ($value, $key) => [Str::snake($key) => $value])
                ->put('created_at', Carbon::now())
                ->put('updated_at', Carbon::now())
                ->toArray())
            ->toArray();
    }

    private function countries(): Collection
    {
        return (new Collection(File::directories(self::Localities)))
            ->map(fn ($dir) => Country::where('iso_3166_3', basename($dir))->first())
            ->filter();
    }
}
