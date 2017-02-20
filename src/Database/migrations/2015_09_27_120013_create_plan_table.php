<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function(Blueprint $table) {
          $table->increments('id');
          $table->integer('society_id')->nullable();
          $table->integer('service_id')->nullable();
          $table->integer('planyear')->nullable();
          $table->integer('planmonth')->nullable();
          $table->integer('planday')->nullable();
          $table->integer('preacher_id')->nullable();
          $table->string('servicetype')->nullable();
          $table->nullableTimestamps();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
          Schema::drop('plans');
    }
}
