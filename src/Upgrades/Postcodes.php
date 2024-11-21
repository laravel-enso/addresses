<?php

namespace LaravelEnso\Addresses\Upgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Addresses\Models\Locality;
use LaravelEnso\Addresses\Models\Postcode;
use LaravelEnso\Addresses\Models\Sector;
use LaravelEnso\Upgrade\Contracts\MigratesTable;
use LaravelEnso\Upgrade\Contracts\ShouldRunManually;
use LaravelEnso\Upgrade\Helpers\Table;

class Postcodes implements MigratesTable, ShouldRunManually
{
    private const Bucharest = 'Bucuresti';

    public function isMigrated(): bool
    {
        return Table::hasColumn('postcodes', 'street_type');
    }

    public function migrateTable(): void
    {
        Schema::table('postcodes', function (Blueprint $table) {
            $table->foreignIdFor(Sector::class)->nullable()
                ->after('locality_id')
                ->constrained();
            $table->string('street_type')->nullable()->after('city');
            $table->renameColumn('street', 'street_name');
            $table->string('street_number')->nullable()->after('street_name');
        });

        $bucharest = Locality::firstWhere('name', self::Bucharest);

        if (! $bucharest->sectors()->exists()) {
            $seeder = 'LaravelEnso\Addresses\Database\Seeders\SectorSeeder';
            Artisan::call('db:seed', ['--force' => true, '--class' => $seeder]);
        }

        Schema::disableForeignKeyConstraints();

        Postcode::truncate();

        $seeder = 'LaravelEnso\Addresses\Database\Seeders\PostcodeSeeder';
        Artisan::call('db:seed', ['--force' => true, '--class' => $seeder]);

        Schema::enableForeignKeyConstraints();
    }
}
