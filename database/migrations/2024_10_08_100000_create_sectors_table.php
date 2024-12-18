<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Addresses\Models\Sector;
use LaravelEnso\Upgrade\Helpers\Table;

return new class extends Migration {
    public function up()
    {
        Schema::create('sectors', function (Blueprint $table) {
            $table->id();

            $table->integer('locality_id')->unsigned()->index();
            $table->foreign('locality_id')->references('id')->on('localities');

            $table->string('name');

            $table->timestamps();
        });

        Schema::table('addresses', fn (Blueprint $table) => $table
            ->foreignIdFor(Sector::class)->nullable()
            ->after('locality_id')
            ->constrained());

        Schema::table('postcodes', fn (Blueprint $table) => $table
            ->foreignIdFor(Sector::class)
            ->after('locality_id')
            ->nullable()
            ->constrained());
    }

    public function down()
    {
        if (Table::hasColumn('addresses', 'sectory_id')) {
            Schema::table('addresses', fn (Blueprint $table) => $table
                ->dropColumn('sector_id'));
        }

        if (Table::hasColumn('postcodes', 'sectory_id')) {
            Schema::table('postcodes', fn (Blueprint $table) => $table
                ->dropColumn('sector_id'));
        }

        Schema::dropIfExists('sectors');
    }
};
