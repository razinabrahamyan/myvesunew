<?php

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRidesTable extends Migration
{
    use SoftDeletes;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rides', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('passengers')->default(0);
            $table->integer('share_id');
            $table->integer('driver_id')->nullable();
            $table->enum('baby_seat',['0','1'])->default('0');
            $table->integer('suitcase')->default(0);
            $table->string('info')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->integer('price')->nullable();
            $table->string('pick_up')->nullable();
            $table->string('pick_up_lat')->nullable();
            $table->string('pick_up_lng')->nullable();
            $table->string('count')->nullable();
            $table->integer('destination')->nullable();
            $table->string('image')->nullable();
            $table->string('invoice')->nullable();
            $table->enum('additional',['0','1'])->nullable();
            $table->enum('type',['driver','passenger']);
            $table->enum('shared',['0','1'])->default('0');
            $table->enum('payment',['cash','card'])->default('card')->nullable();
            $table->json('stops')->nullable();
            $table->enum('status',['active','is_on','ended'])->nullable();
            $table->softDeletes();
            $table->index(['deleted_at']);
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
        Schema::dropIfExists('rides');
    }
}
