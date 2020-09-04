<?php

namespace LaravelEnso\Addresses\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use LaravelEnso\Addresses\Models\Locality;
use LaravelEnso\Addresses\Models\Postcode;
use LaravelEnso\Addresses\Models\Region;
use LaravelEnso\Addresses\Models\Township;
use LaravelEnso\Countries\Models\Country;

class UpdateSources
{
    public function handle()
    {
        $this->countries()->each(fn (Country $country) => $this
            ->refreshRegions($country)
            ->refreshTownships($country)
            ->refreshLocalities($country)
            ->refreshPostcodes($country));
    }

    private function refreshRegions(Country $country): self
    {
        $regions = Region::query()
            ->whereCountryId($country->id)
            ->get(['id', 'abbreviation', 'name', 'is_active'])
            ->sort()->values()->toJson();

        File::put($this->path('regions', "{$country->iso_3166_3}.json"), $regions);

        return $this;
    }

    private function refreshTownships(Country $country): self
    {
        $townships = Township::query()
            ->whereHas('region', fn ($region) => $region->whereCountryId($country->id))
            ->get(['id', 'region_id', 'name'])
            ->sort()->values();

        if ($townships->isNotEmpty()) {
            File::put(
                $this->path('townships', "{$country->iso_3166_3}.json"),
                $townships->toJson()
            );
        }

        return $this;
    }

    private function refreshLocalities(Country $country): self
    {
        File::ensureDirectoryExists($this->path('cities', $country->iso_3166_3));

        (new Collection(File::files($this->path('cities', $country->iso_3166_3))))
            ->each(fn ($file) => File::put(
                $file->getPathname(),
                $this->localities($file->getBasename('.json'))->toJson()
            ));

        return $this;
    }

    private function refreshPostcodes(Country $country): self
    {
        $postcodes = Postcode::query()
            ->whereCountryId($country->id)
            ->select(['id', 'code', 'region_id'])
            ->when(
                $country->id === 1,
                fn ($query) => $query->addSelect(['township_id', 'locality_id', 'street']),
                fn ($query) => $query->addSelect(['city', 'lat', 'long']),
            )->get()->sort()->values()->toJson();

        File::put($this->path('postcodes', "{$country->iso_3166_3}.json"), $postcodes);

        return $this;
    }

    private function localities(string $abbreviaton): Collection
    {
        return Locality::whereHas('region', fn ($query) => $query->whereAbbreviation($abbreviaton))
            ->get(['id', 'region_id', 'township_id', 'name', 'is_active'])
            ->sort()->values();
    }

    private function countries(): Collection
    {
        return (new Collection(File::files($this->path('regions'))))
            ->map(fn ($file) => Country::where('iso_3166_3', $file->getBasename('.json'))->first())
            ->filter();
    }

    private function path(string $type, string $path = ''): string
    {
        return (new Collection([
            base_path('vendor/laravel-enso/addresses/database'),
            $type,
            $path,
        ]))->implode(DIRECTORY_SEPARATOR);
    }
}
