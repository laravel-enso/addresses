<?php

namespace LaravelEnso\Addresses\Upgrades;

use Illuminate\Support\Facades\Schema;
use LaravelEnso\Addresses\Models\Region;
use LaravelEnso\Upgrade\Contracts\MigratesData;
use LaravelEnso\Upgrade\Contracts\MigratesTable;

class Abbreviation implements MigratesTable, MigratesData
{
    public function isMigrated(): bool
    {
        return Region::whereAbbreviation('CORN')->exists();
    }

    public function migrateTable(): void
    {
        Schema::table('regions', fn ($table) => $table->string('abbreviation', 4)->change());
    }

    public function migrateData(): void
    {
        Region::whereAbbreviation('CON')->update(['abbreviation' => 'CORN']);
    }
}
