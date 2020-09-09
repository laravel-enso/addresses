<?php

namespace LaravelEnso\Addresses\Upgrades;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Addresses\Models\Township as Model;
use LaravelEnso\Upgrade\Contracts\Applicable;
use LaravelEnso\Upgrade\Contracts\MigratesData;

class Township implements MigratesData, Applicable
{
    public function applicable(): bool
    {
        return Schema::hasTable('townships');
    }

    public function isMigrated(): bool
    {
        return Model::exists();
    }

    public function migrateData(): void
    {
        Artisan::call('db:seed', [
            '--class' => 'TownshipSeeder',
            '--force' => true,
        ]);
    }
}
