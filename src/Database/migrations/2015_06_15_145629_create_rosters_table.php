<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRostersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rosters', function(Blueprint $table) {
            $table->increments('id');
            $table->string('rostername');
            $table->string('message');
            $table->string('extrainfo');
            $table->string('multichoice');
            $table->string('subcategories');
            $table->integer('dayofweek');
            $table->softDeletes();
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
        Schema::drop('rosters');
    }
}
