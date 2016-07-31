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
        Schema::create('users', function (Blueprint $table){
            $table->increments('id');
            $table->string('first_name',50);
            $table->string('middle_name',50);
            $table->string('last_name',50);
            $table->enum('prefix', ['Mr', 'Mrs']);
            $table->enum('gender', ['Male', 'Female']);
            $table->date('dob');
            $table->enum('marital_status', ['Single', 'Married']);
            $table->enum('employment', ['Employed', 'Unemployed']);
            $table->string('employer',50);
            $table->string('email',50);
            $table->integer('role_id');
            $table->string('github_id',50);
            $table->string('password',50);
            $table->string('image',20);
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
