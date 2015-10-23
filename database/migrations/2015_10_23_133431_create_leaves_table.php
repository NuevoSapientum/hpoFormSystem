<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
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
            $table->integer('leave_type');
            $table->text('reason');
            $table->text('purpose');
            $table->integer('permission_id1')->unsigned();
            $table->foreign('permission_id1')->references('id')
                  ->on('users')->onDelete('cascade');
            $table->integer('permission_id2')->unsigned();
            $table->foreign('permission_id2')->references('id')
                  ->on('users')->onDelete('cascade');
            $table->integer('permission_1');
            $table->integer('permission_2');
            $table->integer('days_applied');
            $table->date('start_date');
            $table->integer('status')->default(0);
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
        $table->drop('leaves');
    }
}
