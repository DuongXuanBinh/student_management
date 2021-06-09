<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Subjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('subjects', function (Blueprint $table){
             $table->unique(array('department_id','name'));
             $table->id();
             $table->string('name');
             $table->unsignedBigInteger('department_id');
             $table->foreign('department_id')->references('id')->on('departments');
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
        Schema::dropIfExists('subjects');
    }
}
