<?php

use Illuminate\Database\Migrations\Migration;
use LaravelEnso\AddressesManager\app\Classes\CountriesDirectory;
use LaravelEnso\AddressesManager\app\Models\Country;

class InsertAllCountries extends Migration
{
    public function up()
    {
        $cd = new CountriesDirectory();

        if (config('app.env') === 'testing') {
            $countries = collect($cd->all());
            \DB::table('countries')->insert($countries->slice(0, 10)->all());

            return;
        }

        foreach ($cd->all() as $country) {
            Country::create($country);
        }
    }

    public function down()
    {
        \DB::table('countries')->delete();
    }
}
