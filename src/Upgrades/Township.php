<?php

namespace LaravelEnso\Addresses\Upgrades;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Addresses\Models\Township as Model;
use LaravelEnso\Upgrade\Contracts\MigratesData;

class Township implements MigratesData
{
    public function migrateData(): void
    {
        ini_set('memory_limit', -1);

        Artisan::call('db:seed', [
            '--class' => 'TownshipSeeder',
            '--force' => true,
        ]);
    }

    public function isMigrated(): bool
    {
        return ! Schema::hasTable('townships') || Model::exists();
    }
}
