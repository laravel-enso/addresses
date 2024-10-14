<?php

namespace LaravelEnso\Addresses\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use LaravelEnso\Addresses\Models\Locality;

class BucharestSectorSeeder extends Seeder
{
    private const Bucharest = 'Bucuresti';

    public function run()
    {
        $bucharest = Locality::firstWhere('name', self::Bucharest);
        $sectors = Collection::range(1, 6)
            ->map(fn ($sector) => ['name' => $sector]);
        $bucharest->sectors()->createMany($sectors);
    }
}
