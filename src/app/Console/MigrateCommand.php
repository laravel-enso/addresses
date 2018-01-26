<?php

namespace LaravelEnso\AddressesManager\App\Console;

use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\AddressesManager\app\Classes\CountriesDirectory;
use LaravelEnso\AddressesManager\app\Models\Country;

class MigrateCommand extends Command
{
    protected $signature = 'enso:migrate 
        {--buildingType : Add the building_type column}
        {--countries : Update the countries table}';
    protected $description = 'Run the commands necessary to migrate table structure changes';

    public function handle()
    {
        if ($this->option('buildingType')) {
            $this->adjustForBuildingType();
        }

        if ($this->option('countries')) {
            $this->migrateCountries();
        }
    }

    private function adjustForBuildingType()
    {
        if ($this->isBuildingTypePresent()) {
            $this->info('The building_type column has already been added.');
            $this->info('No changes have been made.');

            return;
        }

        Schema::table('addresses', function (Blueprint $table) {
            $table->string('building_type')->nullable()->after('entry');
        });
        $this->line('The building_type column has been added to the addresses table');
    }

    private function isBuildingTypePresent()
    {
        $columns = Schema::getColumnListing('addresses');

        return in_array('building_type', $columns);
    }

    private function migrateCountries()
    {
        if ($this->isCountriesTableMigrated()) {
            $this->info('The countries table appears to have already been migrated.');
            $this->info('No changes have been made.');

            return;
        }

        Schema::dropIfExists('addresses');
        Schema::dropIfExists('countries');
        Schema::create('countries', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name', 255);
            $table->string('iso_3166_2', 2);
            $table->string('iso_3166_3', 3);
            $table->string('capital', 255)->nullable();
            $table->string('citizenship', 255)->nullable();
            $table->string('country_code', 3)->nullable();
            $table->string('currency', 255)->nullable();
            $table->string('currency_code', 255)->nullable();
            $table->string('currency_sub_unit', 255)->nullable();
            $table->string('currency_symbol', 3)->nullable();
            $table->integer('currency_decimals')->nullable();
            $table->string('full_name', 255)->nullable();

            $table->string('region_code', 3)->default('');
            $table->string('sub_region_code', 3)->default('');
            $table->boolean('eea')->default(0);
            $table->string('calling_code', 3)->nullable();
            $table->string('flag', 6)->nullable();

            $table->timestamps();
        });
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');

            $table->morphs('addressable');

            $table->integer('country_id')->unsigned()->index();
            $table->foreign('country_id')->references('id')->on('countries');

            $table->smallInteger('type')->default(0);
            $table->boolean('is_default')->default(true);
            $table->string('apartment')->nullable();
            $table->string('floor')->nullable();
            $table->string('entry')->nullable();
            $table->string('building')->nullable();
            $table->string('building_type')->nullable();
            $table->string('number')->nullable();
            $table->string('street')->nullable();
            $table->string('street_type')->nullable();
            $table->string('sub_administrative_area')->nullable();
            $table->string('city');
            $table->string('administrative_area')->nullable();
            $table->string('postal_area')->nullable();
            $table->string('obs')->nullable();
            $table->float('lat', 10, 6)->nullable();
            $table->float('long', 10, 6)->nullable();

            $table->integer('created_by')->unsigned()->index()->nullable();
            $table->foreign('created_by')->references('id')->on('users');

            $table->timestamps();
        });

        $cd = new CountriesDirectory();
        foreach ($cd->all() as $country) {
            Country::create($country);
        }

        $this->line('The countries table has been migrated');
    }

    private function isCountriesTableMigrated()
    {
        $columns = Schema::getColumnListing('countries');

        return in_array('capital', $columns);
    }
}
