<?php

use Illuminate\Database\Seeder;

class FormTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('form_types')->insert([
                ['form_name' => 'Exit Pass', 'description' => 'Exit Pass Form'],
                ['form_name' => 'Request for Leave of Absence', 'description' => 'Request for Leave of Absence'],
                ['form_name' => 'Change of Schedule', 'description' => 'Change of Schedule Form'],
                ['form_name' => 'Overtime Authorization Slip', 'description' => 'Overtime Authorization Slip'],
        ]);
    }
}
