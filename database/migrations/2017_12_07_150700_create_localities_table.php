<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up()
    {
        Schema::create('localities', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('region_id')->unsigned()->index();
            $table->foreign('region_id')->references('id')->on('regions')
                ->onUpdate('restrict')->onDelete('restrict');

            $table->integer('township_id')->nullable()->unsigned()->index();
            $table->foreign('township_id')->references('id')->on('townships')
                ->onUpdate('restrict')->onDelete('restrict');

            $table->string('name');

            $table->float('lat', 10, 6)->nullable();
            $table->float('long', 10, 6)->nullable();

            $table->boolean('is_active');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('localities');
    }
};
