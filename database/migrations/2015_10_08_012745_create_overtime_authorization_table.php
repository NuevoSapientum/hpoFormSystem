<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOvertimeAuthorizationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('overtime_authorization', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')
                    ->on('users')->onDelete('cascade');
            $table->integer('department_id')->unsigned();
            $table->foreign('department_id')->references('id')
                    ->on('departments')->onDelete('cascade');;
            $table->integer('form_id')->unsigned();
            $table->foreign('form_id')->references('id')
                    ->on('form_types')->onDelete('cascade');
            $table->text('reason');    
            $table->integer('status')->default(0);
            $table->integer('client_id');
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
        Schema::drop('overtime_authorization');
    }
}
