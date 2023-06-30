<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJoinRidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('join_rides', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('ride_id');
            $table->enum('approved', ['0','1','wait']);
            $table->enum('status', ['wait', 'piked_up', 'ended', 'paid']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('join_rides');
    }
}
