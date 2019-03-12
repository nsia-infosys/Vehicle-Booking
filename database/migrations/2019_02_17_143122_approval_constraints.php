<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class approvalConstraints extends Migration
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
            DB::statement("ALTER TABLE bookings ADD CONSTRAINT not_null_all_if_approval_true CHECK
            (approval = false or (plate_no is not null and driver_id is not null and approval_pickup_time is not null
            and approval_return_time is not null and approver_description is not null and approver_user_id
            is not null ))" );
        });
        
        DB::statement("ALTER TABLE bookings 
                        ADD CONSTRAINT null_all_if_approval_null 
                        CHECK (approval is not null or(plate_no is null and driver_id is null 
                        and approver_description is null and approval_pickup_time is  null
                        and approval_return_time is  null and approver_user_id is  null))");

        DB::statement("ALTER TABLE bookings
                        ADD CONSTRAINT approver_description_and_approver_id_if_false 
                            CHECK (approval = true OR
                            plate_no IS NULL AND driver_id IS NULL AND approver_description IS NOT NULL
                            AND approval_pickup_time IS NULL AND approval_return_time IS NULL 
                            AND approver_user_id IS NOT NULL)");
   
                        
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
            DB::statement("ALTER TABLE bookings DROP CONSTRAINT null_all_if_approval_null");
            DB::statement("ALTER TABLE bookings DROP CONSTRAINT not_null_all_if_approval_true");
            DB::statement("ALTER TABLE bookings DROP CONSTRAINT approver_description_and_approver_id_if_false");
        });
    }
}