<?php

namespace LaravelEnso\AddressesManager\App\Console;

use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MigrateCommand extends Command
{
    protected $signature = 'enso:migrate {--buildingType : Add the building_type column}';
    protected $description = 'Run the commands necessary to migrate table structure changes';

    public function handle()
    {
        if ($this->option('buildingType')) {
            $this->adjustForBuildingType();
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
}
