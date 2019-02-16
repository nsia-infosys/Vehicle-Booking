<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNullConditionalConstraint extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            //
            DB::statement("ALTER TABLE bookings ADD CONSTRAINT null_for_driverID_and_carID_booking CHECK
            (approval = false or (car_id is not null and driver_id is not null))" );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking', function (Blueprint $table) {
            //
            DB::statement("ALTER TABLE bookings DROP CONSTRAINT null_for_driverID_and_carID_booking");
        });
    }
}
