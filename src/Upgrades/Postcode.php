<?php

namespace LaravelEnso\Addresses\Upgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Addresses\Models\Locality;
use LaravelEnso\Addresses\Models\Postcode as Model;
use LaravelEnso\Upgrade\Contracts\Applicable;
use LaravelEnso\Upgrade\Contracts\MigratesPostDataMigration;
use LaravelEnso\Upgrade\Contracts\MigratesTable;
use LaravelEnso\Upgrade\Contracts\Prioritization;

class Postcode implements MigratesPostDataMigration, Prioritization, MigratesTable, Applicable
{
    public function applicable(): bool
    {
        return Schema::hasTable('postcodes');
    }

    public function isMigrated(): bool
    {
        return Schema::hasColumn('postcodes', 'township_id');
    }

    public function priority(): int
    {
        return 300;
    }

    public function migrateTable(): void
    {
        Schema::table('postcodes', function (Blueprint $table) {
            $table->unsignedInteger('township_id')->nullable()->index()->after('region_id');
            $table->foreign('township_id')->references('id')->on('townships');
        });
    }

    public function migratePostDataMigration(): void
    {
        Locality::get(['id', 'region_id', 'township_id'])
            ->each(fn ($locality) => Model::query()
                ->whereRegionId($locality->region_id)
                ->whereLocalityId($locality->id)
                ->update(['township_id' => $locality->township_id]));
    }
}
