<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostcodesTable extends Migration
{
    public function up()
    {
        Schema::create('postcodes', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('country_id')->index();
            $table->foreign('country_id')->references('id')->on('countries')
                ->onUpdate('restrict')->onDelete('restrict');

            $table->unsignedInteger('region_id')->index();
            $table->foreign('region_id')->references('id')->on('regions')
                ->onUpdate('restrict')->onDelete('restrict');

            $table->unsignedInteger('locality_id')->index()->nullable();
            $table->foreign('locality_id')->references('id')->on('localities')
                ->onUpdate('restrict')->onDelete('restrict');

            $table->string('code');
            $table->string('city')->nullable();
            $table->string('street')->nullable();

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
}
