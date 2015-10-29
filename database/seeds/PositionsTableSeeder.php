<?php

use Illuminate\Database\Seeder;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('positions')->insert([
        		['position_name' => 'Secretary', 'department_id' => 1],
                ['position_name' => 'QA and Documentation Specialists', 'department_id' => 6],
                ['position_name' => 'System Administrator', 'department_id' => 3],
                ['position_name' => 'Project Manager Officer', 'department_id' => 2],
                ['position_name' => 'Management Trainee', 'department_id' => 8],
                ['position_name' => 'Software Testing', 'department_id' => 3],
        ]);
    }
}
