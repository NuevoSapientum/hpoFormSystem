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
            $table->string('emp_gender');
            $table->integer('shift_id')->unsigned();
            $table->foreign('shift_id')->references('id')
                  ->on('shifts')->onDelete('cascade');
            $table->integer('position_id')->unsigned();
            $table->foreign('position_id')->references('id')
                 ->on('positions')->onDelete('cascade');
            $table->integer('img_id')->unsigned();
            $table->foreign('img_id')->references('id')
                 ->on('profile_image')->onDelete('cascade');
            $table->string('email');
            $table->integer('username')->unique();
            $table->string('password', 60);
            $table->integer('permissioners');
            $table->integer('VL_entitlement');
            $table->integer('SL_entitlement');
            $table->integer('ML_entitlement');
            $table->integer('PL_entitlement');
            $table->integer('VL_taken')->default(0);
            $table->integer('SL_taken')->default(0);
            $table->integer('ML_taken')->default(0);
            $table->integer('PL_taken')->default(0);
            $table->rememberToken();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
           
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
