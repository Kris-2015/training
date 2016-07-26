<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address', function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id');
            $table->string('type');
            $table->string('street');
            $table->string('city');
            $table->string('state');
            $table->integer('zip');
            $table->integer('mobile');
            $table->integer('landline');
            $table->integer('fax');
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
        Schema::drop('address');
    }
}
