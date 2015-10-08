<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChangeSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('change_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')
                  ->on('users')->onDelete('cascade');
            $table->integer('department_id')->references('id')
                  ->on('departments')->onDelete('cascade');
            $table->integer('form_id')->unsigned();
            $table->foreign('form_id')->references('id')
                  ->on('form_types')->onDelete('cascade');
            $table->integer('permission_id1')->unsigned();
            $table->foreign('permission_id1')->references('id')
                  ->on('users')->onDelete('cascade');
            $table->integer('permission_id2')->unsigned();
            $table->foreign('permission_id2')->references('id')
                  ->on('users')->onDelete('cascade');
            $table->integer('permission_id3')->unsigned();
            $table->foreign('permission_id3')->references('id')
                  ->on('users')->onDelete('cascade');
            $table->integer('permission_id4')->unsigned();
            $table->foreign('permission_id4')->references('id')
                  ->on('users')->onDelete('cascade');
            $table->text('reason');
            $table->integer('permission_1');
            $table->integer('permission_2');
            $table->integer('permission_3');
            $table->integer('permission_4');
            $table->integer('status');
            $table->timestamps();
            $table->date('date_from');
            $table->date('date_to');
            $table->date('shift_from');
            $table->date('shift_to');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('change_schedules');
    }
}
