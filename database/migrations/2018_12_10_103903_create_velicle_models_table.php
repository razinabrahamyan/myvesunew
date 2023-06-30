<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVelicleModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_models', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->string('code');
          $table->integer('make_id')->unsigned()->index();
          $table->timestamps();
          $table->foreign('make_id')->references('id')->on('vehicle_makes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vehicle_model', function (Blueprint $table) {
            //
        });
    }
}
