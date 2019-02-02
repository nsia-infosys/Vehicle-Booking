<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
         DB::table('cars')->insert([
            'type' => str_random(10),
            'model' => str_random(10),
            'plate_no'=>str_random(10),
            'color' =>str_random(10),
            'driver_id' =>str_random(10),
        ]);
    }
}
