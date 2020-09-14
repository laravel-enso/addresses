<?php

namespace LaravelEnso\Addresses\Upgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Addresses\Models\Locality as Model;
use LaravelEnso\Addresses\Models\Township;
use LaravelEnso\Upgrade\Contracts\Applicable;
use LaravelEnso\Upgrade\Contracts\MigratesPostDataMigration;
use LaravelEnso\Upgrade\Contracts\MigratesTable;
use LaravelEnso\Upgrade\Contracts\Prioritization;

class Locality implements Applicable, MigratesTable, MigratesPostDataMigration, Prioritization
{
    public function applicable(): bool
    {
        return Schema::hasTable('localities');
    }

    public function isMigrated(): bool
    {
        return Schema::hasColumn('localities', 'township_id');
    }

    public function priority(): int
    {
        return 200;
    }

    public function migrateTable(): void
    {
        Schema::table('localities', function (Blueprint $table) {
            $table->integer('township_id')->nullable()->unsigned()->index()->after('region_id');
            $table->foreign('township_id')->references('id')->on('townships');
        });
    }

    public function migratePostDataMigration(): void
    {
        Township::get(['id', 'region_id', 'name'])
            ->each(fn ($township) => Model::query()
                ->whereRegionId($township->region_id)
                ->whereTownship($township->name)
                ->update(['township_id' => $township->id]));

        Schema::table('localities', function (Blueprint $table) {
            $table->renameColumn('township', 'township_name');
            $table->dropColumn(['siruta']);
        });
    }
}
