<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReadingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('readings', function(Blueprint $table) {
            $table->increments('id');
            $table->date('readingdate');
            $table->string('description');
            $table->string('readings');
            $table->text('reading1');
            $table->text('reading2');
            $table->text('reading3');
            $table->text('reading4');
            $table->text('copyright');
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
        Schema::drop('readings');
    }
}
