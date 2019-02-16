<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BookVehicals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('bookVehicals', function (Blueprint $table) {
            $table->integer('user_id');
            $table->tinyInteger('count');
            $table->dateTime('pickup_time');
            $table->dateTime('return_time');            
            $table->longText('description');
            $table->string('destination',255);
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
        //
        Schema::dropIfExists('bookACar');
    }
}
