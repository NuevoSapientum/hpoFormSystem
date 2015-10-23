<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExitPassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exit_pass', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')
                  ->on('users')->onDelete('cascade');
            $table->integer('department_id')->unsigned();
            $table->foreign('department_id')->references('id')
                  ->on('departments')->onDelete('cascade');
            $table->integer('form_id')->unsigned();
            $table->foreign('form_id')->references('id')
                  ->on('form_types')->onDelete('cascade');
            $table->text('reason');
            $table->text('purpose');
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
            $table->integer('permission_1');
            $table->integer('permission_2');
            $table->integer('permission_3');
            $table->integer('permission_4');
            $table->integer('days_applied');
            $table->integer('status')->default(0);
            $table->timestamp('date_from')->default('0000-00-00 00:00:00');
            $table->timestamp('date_to')->default('0000-00-00 00:00:00');
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
        //
    }
}
