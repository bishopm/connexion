<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statistics', function(Blueprint $table) {
            $table->increments('id');
            $table->date('statdate');
            $table->integer('service_id');
            $table->unique(array('statdate', 'service_id'));
            $table->integer('attendance');
            $table->integer('included')->nullable();
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
        Schema::drop('statistics');
    }
}
