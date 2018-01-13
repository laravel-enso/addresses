<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');

            $table->morphs('addressable');

            $table->integer('country_id')->unsigned()->index();
            $table->foreign('country_id')->references('id')->on('countries')->onUpdate('restrict')->onDelete('restrict');

            $table->smallInteger('type')->default(0);
            $table->boolean('is_default')->default(true);

            $table->string('apartment')->nullable();
            $table->string('floor')->nullable();
            $table->string('entry')->nullable();
            $table->string('building')->nullable();
            $table->string('number')->nullable();
            $table->string('street')->nullable();
            $table->string('street_type')->nullable();
            $table->string('sub_administrative_area')->nullable();
            $table->string('city');
            $table->string('administrative_area')->nullable();
            $table->string('postal_area')->nullable();
            $table->string('obs')->nullable();

            $table->float('lat', 10, 6)->nullable();
            $table->float('long', 10, 6)->nullable();

            $table->integer('created_by')->unsigned()->index()->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('restrict')->onDelete('restrict');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
