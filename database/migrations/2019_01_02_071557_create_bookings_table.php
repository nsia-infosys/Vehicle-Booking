<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('booking_id');
            $table->dateTime('pickup_time');
            $table->dateTime('return_time');
            $table->tinyInteger('count');
            $table->longText('description');
            $table->string('destination');
            $table->boolean('approval')->nullable();
            $table->longText('approver_description')->nullable();
            $table->dateTime('approval_pickup_time')->nullable();
            $table->dateTime('approval_return_time')->nullable();
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
        Schema::dropIfExists('bookings');
    }
}
