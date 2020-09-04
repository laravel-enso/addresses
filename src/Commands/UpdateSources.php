<?php

namespace  LaravelEnso\Addresses\Commands;

use Illuminate\Console\Command;
use LaravelEnso\Addresses\Jobs\UpdateSources as Job;

class UpdateSources extends Command
{
    protected $signature = 'enso:addresses:update-sources';

    protected $description = 'Updates addresses json files according to database data';

    public function handle()
    {
        Job::dispatch();
    }
}
