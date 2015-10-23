<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        		'emp_name' => 'Admin',
        		'emp_gender' => 'Female',
        		'shift_id' => '15',
        		'position_id' => '1',
        		'img_id' => '1',
        		'email' => 'admin@example.com',
        		'username' => '10001',
        		'password' => bcrypt('p@ssw0rd'),
        		'permissioners' => '0',
        		'VL_entitlement' => '7',
        		'SL_entitlement' => '12',
        		'ML_entitlement' => '68',
        		'PL_entitlement' => '0',
        ]);
    }
}
