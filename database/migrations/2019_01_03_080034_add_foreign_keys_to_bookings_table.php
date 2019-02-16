<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->integer('driver_id')->unsigned()->nullable();
            $table->foreign('driver_id')->references('driver_id')->on('drivers')->onDelete('no action');

        });

        Schema::table('bookings',function (Blueprint $table){
            $table->integer('car_id')->unsigned()->nullable();
            $table->foreign('car_id')->references('car_id')->on('cars')->onDelete('no action');
        });

        Schema::table('bookings',function (Blueprint $table){
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            //

        
        });
    }
}
