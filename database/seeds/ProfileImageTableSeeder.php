<?php

use Illuminate\Database\Seeder;

class ProfileImageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('profile_image')->insert([
        		'picture_name' => 'blank',
        		'image' => 'blank',
        ]);
    }
}
