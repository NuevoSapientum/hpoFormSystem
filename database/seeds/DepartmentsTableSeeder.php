<?php

use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
                ['department_name' => 'Human Resource'],
                ['department_name' => 'HPO Operations'],
                ['department_name' => 'SysAd'],
                ['department_name' => 'HR and Finance'],
                ['department_name' => 'KSI Operations'],
                ['department_name' => 'Engage IQ'],
                ['department_name' => 'DTR'],
                ['department_name' => 'Sales & Marketing'],
        ]);
    }
}
