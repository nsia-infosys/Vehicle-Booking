<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UniqueDriverId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('cars', function (Blueprint $table) {
           

            $table->integer('driver_id')->unsigned()->nullable();
            $table->foreign('driver_id')->references('driver_id')->on('drivers')->onDelete('set null');

            $table->unique('driver_id');
    });}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
     
        Schema::table('cars', function (Blueprint $table) {
            
        });   
    }
}
