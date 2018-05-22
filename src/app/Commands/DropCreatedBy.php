<?php

namespace LaravelEnso\AddressesManager\app\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class DropCreatedBy extends Command
{
    protected $signature = 'enso:addresses:drop-created-by';

    protected $description = 'This command will drop the obsolete `created_by` column from the `addresses` table';

    public function handle()
    {
        if (!Schema::hasColumn('addresses', 'created_by')) {
            $this->info('The `created_by` column was already dropped.');

            return;
        }

        Schema::table('addresses', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn('created_by');
        });

        $this->info('The `created_by` column was successfully dropped.');
    }
}
