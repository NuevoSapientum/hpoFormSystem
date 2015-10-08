<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('emp_name');
            $table->integer('position_id')->unsigned();
            $table->foreign('position_id')->references('id')
                 ->on('positions')->onDelete('cascade');
            $table->integer('img_id')->nullable()->unsigned();
            $table->foreign('img_id')->references('id')
                 ->on('profile_image')->onDelete('cascade');
            $table->string('email');
            $table->integer('username')->unique();
            $table->string('password', 60);
            $table->integer('permissioners');
            $table->integer('entitlement');
            $table->integer('days_taken')->default(0);
            $table->timestamps();
           
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
