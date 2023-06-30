<?php

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDriverCarsTable extends Migration
{
    use SoftDeletes;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_cars', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('driver_id')->unsigned();
            $table->string('type')->nullable();
            $table->string('make')->nullable();
            $table->string('model')->nullable();
            $table->string('year')->nullable();
            $table->string('color')->nullable();
            $table->integer('number_of_passenger')->nullable();
            $table->integer('number_of_suitcases')->nullable();
            $table->enum('baby_booster_seat', ['0', '1'])->default('0');
            $table->text('additional_info')->nullable();
            $table->string('vehicle_registration_number')->unique();
            $table->string('vehicle_photo')->default('no_vehicle_photo.png');
            $table->softDeletes();
            $table->index(['deleted_at']);
            $table->timestamps();

            $table->foreign('driver_id')->references('id')->on('drivers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('driver_cars');
    }
}
