<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('postcodes', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('country_id')->unsigned()->index();
            $table->foreign('country_id')->references('id')->on('countries')
                ->onUpdate('restrict')->onDelete('restrict');

            $table->integer('region_id')->unsigned()->index();
            $table->foreign('region_id')->references('id')->on('regions')
                ->onUpdate('restrict')->onDelete('restrict');

            $table->integer('township_id')->unsigned()->nullable()->index();
            $table->foreign('township_id')->references('id')->on('townships')
                ->onUpdate('restrict')->onDelete('restrict');

            $table->integer('locality_id')->unsigned()->index()->nullable();
            $table->foreign('locality_id')->references('id')->on('localities')
                ->onUpdate('restrict')->onDelete('restrict');

            $table->string('code');
            $table->string('city')->nullable();
            $table->string('street_type')->nullable();
            $table->string('street_name')->nullable();
            $table->string('street_number')->nullable();

            $table->float('lat', 10, 6)->nullable();
            $table->float('long', 10, 6)->nullable();

            $table->unique(['country_id', 'code']);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('postcodes');
    }
};
