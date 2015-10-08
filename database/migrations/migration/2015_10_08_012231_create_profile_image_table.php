<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfileImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_image', function (Blueprint $table) {
            $table->increments('id');
            $table->string('picture_name');
           
      
        });
        DB::statement("ALTER TABLE profile_image ADD image LONGBLOB");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('profile_image');
        DB::statement("ALTER TABLE profile_image DROP image LONGBLOB");
    }
}
