<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateDriversTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('drivers', function (Blueprint $table) {
            $table->increments('driver_id');
             $table->string('name');
             $table->string('father_name');
             $table->string('phone_no',14);
             $table->boolean('status');
            $table->timestamps();  });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drivers');
    }
}
