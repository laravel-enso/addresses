<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('townships', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('region_id')->unsigned()->index();
            $table->foreign('region_id')->references('id')->on('regions')
                ->onUpdate('restrict')->onDelete('restrict');

            $table->string('name');

            $table->unique(['region_id', 'name']);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('townships');
    }
};
