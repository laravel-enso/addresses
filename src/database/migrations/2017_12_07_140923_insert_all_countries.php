<?php

use Illuminate\Database\Migrations\Migration;
use LaravelEnso\AddressesManager\app\Models\Country;

class InsertAllCountries extends Migration
{
    const CountriesJSON = __DIR__.'/../../database/countries.json';

    public function up()
    {
        if (config('app.env') === 'testing') {
            \DB::table('countries')
                ->insert($this->countries()->slice(0, 10)->all());

            return;
        }

        $this->countries()->each(function ($country) {
            Country::create($country);
        });
    }

    public function down()
    {
        \DB::table('countries')->delete();
    }

    public function countries()
    {
        $countries = json_decode(\File::get(self::CountriesJSON), true);

        return collect($countries);
    }
}
