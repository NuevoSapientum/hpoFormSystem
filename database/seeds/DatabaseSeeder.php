<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(DepartmentsTableSeeder::class);
        $this->call(PositionsTableSeeder::class);
        $this->call(ProfileImageTableSeeder::class);
        $this->call(ShiftsTableSeeder::class);
        $this->call(UsersTableSeeder::class);

        Model::reguard();
    }
}
