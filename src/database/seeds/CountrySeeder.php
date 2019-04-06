<?php

use Illuminate\Database\Seeder;
use LaravelEnso\AddressesManager\app\Models\Country;

class CountrySeeder extends Seeder
{
    const CountriesJSON = __DIR__.'/../../vendor/laravel-enso/addressesmanager/src/database/countries.json';

    public function run()
    {
        if (app()->environment() === 'testing') {
            Country::createMany(
                $this->countries()->slice(0, 10)
            );

            return;
        }

        Country::createMany($this->countries());
    }

    public function countries()
    {
        return collect(
            json_decode(\File::get(self::CountriesJSON), true)
        );
    }
}
