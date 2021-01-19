<?php

namespace LaravelEnso\Addresses\Upgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Upgrade\Contracts\MigratesTable;
use LaravelEnso\Upgrade\Helpers\Table;

class AddCreatedBy implements MigratesTable
{
    public function isMigrated(): bool
    {
        return Table::hasColumn('addresses', 'created_by');
    }

    public function migrateTable(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->integer('created_by')->unsigned()->index()->nullable()
                ->after('is_shipping');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }
}
