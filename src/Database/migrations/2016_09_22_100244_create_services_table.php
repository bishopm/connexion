<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('services', function(Blueprint $table) {
          $table->increments('id');
          $table->integer('society_id');
          $table->string('servicetime');
          $table->string('language');          
          $table->text('description')->nullable();
          $table->softDeletes();
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
        Schema::drop('services');
    }
}
