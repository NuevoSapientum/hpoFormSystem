<?php

use Illuminate\Database\Seeder;

class ShiftsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shifts')->insert([
        		['shift_from' => '09:00:00', 'shift_to' => '17:00:00'],
        		['shift_from' => '08:30:00', 'shift_to' => '17:30:00'],
        		['shift_from' => '22:00:00', 'shift_to' => '06:00:00'],
        		['shift_from' => '23:00:00', 'shift_to' => '08:00:00'],
        		['shift_from' => '14:00:00', 'shift_to' => '22:00:00'],
        		['shift_from' => '06:00:00', 'shift_to' => '14:00:00'],
        		['shift_from' => '10:00:00', 'shift_to' => '18:00:00'],
        		['shift_from' => '09:00:00', 'shift_to' => '18:00:00'],
        		['shift_from' => '07:00:00', 'shift_to' => '15:00:00'],
        		['shift_from' => '13:00:00', 'shift_to' => '21:00:00'],
        		['shift_from' => '00:00:00', 'shift_to' => '08:00:00'],
        		['shift_from' => '16:00:00', 'shift_to' => '00:00:00'],
        		['shift_from' => '16:00:00', 'shift_to' => '01:00:00'],
        		['shift_from' => '06:00:00', 'shift_to' => '15:00:00'],
        		['shift_from' => '08:00:00', 'shift_to' => '17:00:00'],
        		['shift_from' => '08:00:00', 'shift_to' => '16:00:00'],
        		['shift_from' => '07:00:00', 'shift_to' => '17:00:00'],
        		['shift_from' => '11:00:00', 'shift_to' => '19:00:00'],
        		['shift_from' => '10:00:00', 'shift_to' => '19:00:00'],
        		['shift_from' => '07:00:00', 'shift_to' => '16:00:00'],
     		]);
    }
}
